<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = [
        'Numero', 'Fecha', 'Solicitante', 'Fiador', 'Cantidad',
        'Monto', 'Tipo', 'Tasa', 'Meses', 'NumeroCredito', 'Estado',
        'UsuarioIngreso', 'FechaIngreso', 'UsuarioAprobacion', 'FechaAprobacion',
        'UsuarioAnulacion', 'FechaAnulacion'
    ];
    protected $guarded = [];

    public function saldo($id,$fecha)
    {
        $solicitud = Solicitud::findOrFail($id);
        $fecha_final = Carbon::createFromFormat('Y-m-d', $fecha);
        $recibos = Recibo::where('Solicitud', '=', $id)->get();

        $fecha_inicio = $solicitud->Fecha;
        $capital = $solicitud->Monto;
        $interesMensual = ($solicitud->Tasa / 100);


        if ($recibos->count() > 0) {
            $last_recibo = Recibo::where('Solicitud', '=', $id)->orderBy('Id', 'desc')->first();
            $fecha_inicio = $last_recibo->Fecha;
            $capital = $last_recibo->Total;
        }


        $numMeses = $this->calculoMes($fecha_inicio, $fecha_final->format('Y-m-d'));

        //dd($numMeses,$fecha_inicio, $fecha_final->format('Y-m-d'));
        $deuda = $this->calcularDeuda($capital, $interesMensual, $numMeses);
        $interes = round(($deuda - $capital), 2);


        //para validar si hay recibo del ismo mes donde se halla cobrado interes
        if ($this->validarMes($fecha_inicio, $fecha_final->format('Y-m-d')) == true && $recibos->count() > 0) {
            if ($last_recibo->Interes > 0) {
                $interes = 0;
            }
        }


        $response = round($capital+ $interes, 2);

        return $response;
    }



    public function calculoMes($fecha_inicio, $fecha_final)
    {
        $inicio = Carbon::parse($fecha_inicio);
        $final = Carbon::parse($fecha_final);

        // Verificar si el año y el mes son iguales
        if ($inicio->format('Y-m') == $final->format('Y-m')) {
            return 1;
        }

        // Ajustar para asegurarse de que las fechas estén en el primer día del mes
        $inicio = $inicio->firstOfMonth();
        $final = $final->firstOfMonth();

        // Calcular el número de meses afectados
        $mesesAfectados = $final->diffInMonths($inicio);

        // Asegurarse de contar el mes inicial
        $mesesAfectados += 1;

        return $mesesAfectados;
    }


    public function calcularDeuda($capital, $interesMensual, $numMeses)
    {
        $deudaTotal = 0;

        for ($mes = 1; $mes <= $numMeses; $mes++) {
            $interes = $capital * $interesMensual;
            $capital += $interes;
            $deudaTotal = $capital;  // Actualizamos la deuda total con el nuevo capital, no sumamos al acumulado
        }

        // Redondear a dos decimales sin convertir a cadena
        $deudaTotal = round($deudaTotal, 2);

        return $deudaTotal;
    }

    public function validarMes($fecha_inicio, $fecha_final)
    {
        $response = false;
        $inicio = explode('-', $fecha_inicio);
        $final = explode('-', $fecha_final);

        // Verificar si el mes y el año son iguales
        if ($inicio[0] == $final[0] && $inicio[1] == $final[1]) {
            return true;
        }

        return $response;
    }



    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'Tipo', 'Id');
    }
    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'Estado', 'Id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Solicitante', 'Id');
    }

    public function fiador()
    {
        return $this->belongsTo(Persona::class, 'Fiador', 'Id');
    }
}
