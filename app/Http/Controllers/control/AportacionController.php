<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Mail\AportacionMail;
use App\Models\Aportacion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AportacionController extends Controller
{

    public function index()
    {
        return view('control.aportacion.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reporte_aportacion($socio, $mes, $axo, $opcion)
    {
        $aportacion = Aportacion::where('Socio', '=', $socio)->where('Mes', '=', $mes)->where('Axo', '=', $axo)->first();
        $meses = array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
        //$mes_int = substr($aportacion->Fecha, 5, 2) + 0;

        $mes = $meses[$mes];

        $pdf = \PDF::loadView(
            'reportes.aportacion',
            [
                "aportacion" => $aportacion, "mes" => $mes
            ]
        );

        if ($opcion == 1) {
            return $pdf->download('aportacion.pdf');
        }

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
                alert()->success('El correo ha sido enviado correctamente');
            } else {
                alert()->error('El correo no ha sido enviado');
            }
        } catch (Exception $e) {
            alert()->error('El correo no ha sido enviado correctamente');
        }



        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
