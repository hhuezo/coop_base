<?php

namespace App\Http\Livewire;

use App\Mail\AportacionMail;
use App\Models\Aportacion as ModelsAportacion;
use Livewire\Component;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Aportacion extends Component
{
    public $meses = array(), $axos = array(), $axo, $registros, $mes, $fecha, $socio, $socio_nombre, $cantidad_aportacion;

    public function mount()
    {
        $this->meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $fechaActual = Carbon::now();
        $this->fecha = $fechaActual->format('Y-m-d');
        $this->axo  = $fechaActual->year;

        for ($i = $this->axo; $i >= 2019; $i--) {
            array_push($this->axos, $i);
        }
    }
    public function render()
    {
        $sql = "select persona.Id,persona.Nombre,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 1) as enero,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 2) as febrero,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 3) as marzo,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 4) as abril,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 5) as mayo,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 6) as junio,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 7) as julio,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 8) as agosto,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 9) as septiembre,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 10) as octubre,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 11) as noviembre,
        (select ifnull(sum(aportaciones.Cantidad),0) from aportaciones where aportaciones.Socio = persona.Id and aportaciones.Axo = " . $this->axo . " and aportaciones.Mes = 12) as diciembre
        from persona where Socio = 1 order by persona.Nombre";

        $this->registros = DB::select($sql);

        return view('livewire.aportacion');
    }

    public function modal_aportacion($id)
    {
        $aportacion = ModelsAportacion::where('Socio', '=', $id)->where('Axo', '=', $this->axo)->orderBy('Mes', 'desc')->first();
        $this->mes = $aportacion->Mes + 1;
        $this->socio = $aportacion->Socio;
        $this->socio_nombre = $aportacion->socio->Nombre;
    }

    public function save()
    {
        $max = ModelsAportacion::max('Numero');
        $aportacion = new ModelsAportacion();
        $aportacion->Numero = $max + 1;
        $aportacion->Socio = $this->socio;
        $aportacion->Fecha = $this->fecha;
        $aportacion->Cantidad = $this->cantidad_aportacion;
        $aportacion->Usuario = auth()->user()->id;
        $fechaActual = Carbon::now();
        $aportacion->FechaIngreso = $fechaActual->toDateString();
        $aportacion->Mes = $this->mes;
        $aportacion->Axo = $this->axo;
        $aportacion->save();

        $meses = array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");

        $mes = $meses[$this->mes];

        $pdf = \PDF::loadView(
            'reportes.aportacion',
            [
                "aportacion" => $aportacion, "mes" => $mes
            ]
        );

        try {
            unlink(public_path('aportacion.pdf'));
        } catch (Exception $e) {
            //print "whoops!";
            //or even leaving it empty so nothing is displayed
        }


        try {
            if ($aportacion->socio->Correo) {

                $pdf->save(public_path('aportacion.pdf'));

                $subject = 'Acoesi de RL, aportación registrada';
                $content = "Estimad@ : " . $aportacion->socio->Nombre . ",  Por este medio deseamos informale que se ha registrado satisfactoriamente su aportación correspondiente al mes de " . $mes . " la cual se detalla en el archivo adjunto";
                $recipientEmail = $aportacion->socio->Correo;
                $file = public_path('aportacion.pdf');
                // dd($recipientEmail);
                Mail::to($recipientEmail)->send(new AportacionMail($subject, $content, $file));
            }
        } catch (Exception $e) {
        }


        $this->dispatchBrowserEvent('close-modal');
    }
}
