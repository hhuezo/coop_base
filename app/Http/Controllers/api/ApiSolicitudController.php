<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Solicitud;
use App\Models\Tipo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class ApiSolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('search')) {
            $solicitudes = Solicitud::join('persona as solicitante', 'solicitud.Solicitante', '=', 'solicitante.Id')
                ->join('banco', 'solicitante.Banco', '=', 'banco.Id')
                ->join('tipo', 'solicitud.Tipo', '=', 'tipo.Id')
                ->join('estado', 'solicitud.Estado', '=', 'estado.Id')
                ->select(
                    'solicitud.id',
                    'solicitud.numero',
                    'solicitud.fecha',
                    'solicitante.nombre',
                    'solicitante.numeroCuenta',
                    'banco.Nombre as banco',
                    'solicitud.monto',
                    'solicitud.cantidad',
                    'tipo.Nombre as tipo',
                    'solicitud.tasa',
                    'solicitud.meses',
                    'estado.Nombre as estado',
                    'estado.Id as id_estado'
                )->where('solicitante.Nombre', 'like', '%' . $request->get('search') . '%')
                ->orWhere('solicitud.Numero', 'like', '%' . $request->get('search') . '%')
                ->orderBy('solicitud.Numero', 'desc')
                ->get();
        } else {
            $solicitudes = Solicitud::join('persona as solicitante', 'solicitud.Solicitante', '=', 'solicitante.Id')
                ->join('banco', 'solicitante.Banco', '=', 'banco.Id')
                ->join('tipo', 'solicitud.Tipo', '=', 'tipo.Id')
                ->join('estado', 'solicitud.Estado', '=', 'estado.Id')
                ->select(
                    'solicitud.id',
                    'solicitud.numero',
                    'solicitud.fecha',
                    'solicitante.nombre',
                    'solicitante.numeroCuenta as cuenta',
                    'banco.Nombre as banco',
                    'solicitud.monto',
                    'solicitud.cantidad',
                    'tipo.Nombre as tipo',
                    'solicitud.tasa',
                    'solicitud.meses',
                    'estado.Nombre as estado',
                    'estado.Id as id_estado'
                )
                ->orderBy('solicitud.Numero', 'desc')
                ->get();
        }

        return $solicitudes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $solicitantes = Persona::where('Activo', '=', 1)->get();
        $fiadores = Persona::where('Activo', '=', 1)->where('Socio', '=', 1)->get();
        $tipos = Tipo::get();

        $response = ['solicitantes' => $solicitantes, 'fiadores' => $fiadores, 'tipos' => $tipos];

        return $response;
    }


    public function getFiador($id)
    {
        try{
            $solicitante = Persona::findOrFail($id);

            if ($solicitante) {

                if ($solicitante->Socio == 1) {
                    $response = Persona::select('Id', 'Nombre')->where('Id', '=', 1)->get();
                } else {
                    $response = Persona::select('Id', 'Nombre')->where('Activo', '=', 1)->where('Socio', '=', 1)->get();
                }
            }
        }
        catch(Exception $e)
        {
            $response = Persona::select('Id', 'Nombre')->where('Id', '=', 1)->get();
        }

        return $response;
    }


    public function store(Request $request)
    {
        return "hola";
        /*$messages = [

            'Fecha.required' => 'Fecha es un valor requerido',
            'Solicitante.required' => 'Solicitante es un valor requerido',
            'Cantidad.required' => 'Cantidad es un valor requerido',
            'Tasa.required' => 'La Tasa es un valor requerido',
            'Meses.required' => 'El Mese es un valor requerido'


        ];
        $request->validate([

            'Fecha' => 'required',
            'Solicitante' => 'required',
            'Cantidad' => 'required',
            'Tasa' => 'required',
            'Meses' => 'required',

        ], $messages);

        $max_numero = Solicitud::max('Numero');
        $max_credito = Solicitud::max('NumeroCredito');
        //dd($max_credito);
        //creamos un nuevo registro en la tabla banco, llamando el modelo banco.
        $solicitud = new Solicitud();
        //asignando el valor del formulario al campo de la tabla
        $solicitud->Numero = $max_numero + 1;
        $solicitud->Fecha = $request->Fecha;
        $solicitud->Solicitante = $request->Solicitante;
        $solicitud->Cantidad = $request->Cantidad;
        $solicitud->Monto = $request->Cantidad;
        $solicitud->Tipo = 1;
        $solicitud->Tasa = $request->Tasa;
        $solicitud->Meses = $request->Meses;
        $solicitud->NumeroCredito = $max_credito + 1;
        if ($request->Fiador != "") {
            $solicitud->Fiador = $request->Fiador;
        } else {
            $solicitud->Fiador = 1;
        }
        $solicitud->Estado = 2;
        //FUNCION PROPIA DE LARAVEL QUE TRAE TODOS LOS DATOS DEL USUARIO LOGEADO EN ESTA CASO USAMOS ID
        $solicitud->UsuarioIngreso = auth()->user()->id;

        //fecha actual
        $time = Carbon::now('America/El_Salvador');
        $solicitud->FechaIngreso =  $time->toDateTimeString();

        //guardamos
        $solicitud->save();


        try {
            if ($solicitud->persona->Correo) {

                $meses = array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
                $mes_int = substr($solicitud->Fecha, 5, 2) + 0;

                $mes = $meses[$mes_int];

                $tasa = $solicitud->Tasa / 100;
                $interes_temp = $tasa + 1;
                $interes_temp = pow($interes_temp, ($solicitud->Meses * -1));
                $cuotaMensual = ($tasa * $solicitud->Monto) / (1 - $interes_temp);

                $capital_temporal = $solicitud->Monto;
                $saldo = $solicitud->Monto;

                $tabla_amortizacion = [];

                for ($i = 1; $i <= $solicitud->Meses; $i++) {

                    $interes_temporal = round(($capital_temporal * $tasa), 2);

                    $saldo -= round(($cuotaMensual - $interes_temporal), 2);

                    if ($i == $solicitud->Meses) {
                        $item = ["Pago" => $i, "interes" => $interes_temporal, "capital" => round(($cuotaMensual - $interes_temporal), 2), "saldo" => 0.00];
                    } else {
                        $item = ["Pago" => $i, "interes" => $interes_temporal, "capital" => round(($cuotaMensual - $interes_temporal), 2), "saldo" => round($saldo, 2)];
                    }


                    array_push($tabla_amortizacion, $item);

                    $capital_temporal -= $cuotaMensual - $interes_temporal;
                }

                $pdf = \PDF::loadView(
                    'reportes.solicitud',
                    [
                        "solicitud" => $solicitud, "tabla_amortizacion" => $tabla_amortizacion, "mes" => $mes, "cuotaMensual" => $cuotaMensual,
                        "solicitud" => $solicitud
                    ]
                );

                try {
                    unlink(public_path('solicitud.pdf'));
                } catch (Exception $e) {
                    //print "whoops!";
                    //or even leaving it empty so nothing is displayed
                }

                $pdf->save(public_path('solicitud.pdf'));

                $subject = 'Acoesi de RL, solicitud registrada';
                $content = "Estimad@ : " . $solicitud->persona->Nombre . ",  Por este medio deseamos informale que se ha registrado satisfactoriamente su solicitud la cual se detalla en el archivo adjunto";
                $recipientEmail = $solicitud->persona->Correo;
                $file = public_path('solicitud.pdf');
                // dd($recipientEmail);
                Mail::to($recipientEmail)->send(new VerificacionMail($subject, $content, $file));
            }
        } catch (Exception $e) {
        }






        alert()->success('El registro ha sido creado correctamente');
        return back();*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
