<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\Recibo;
use App\Models\Solicitud;
use App\Models\Tipo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ApiSolicitudController extends Controller
{
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
                    DB::raw("DATE_FORMAT(solicitud.fecha, '%d/%m/%Y') as fecha"),
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
                ->where('estado.Id','<',3)
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
                    DB::raw("DATE_FORMAT(solicitud.fecha, '%d/%m/%Y') as fecha"),
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
                ->where('estado.Id','<',3)
                ->orderBy('solicitud.Numero', 'desc')
                ->get();
        }

        return $solicitudes;
    }

    public function create()
    {
        $solicitantes = Persona::where('Activo', '=', 1)->where('Id', '>', 1)->get();
        $fiadores = Persona::where('Activo', '=', 1)->where('Socio', '=', 1)->get();
        $tipos = Tipo::get();

        $response = ['solicitantes' => $solicitantes, 'fiadores' => $fiadores, 'tipos' => $tipos];

        return $response;
    }


    public function getFiador($id)
    {
        try {
            $solicitante = Persona::findOrFail($id);

            if ($solicitante) {

                if ($solicitante->Socio == 1) {
                    $response = Persona::select('Id', 'Nombre')->where('Id', '=', 1)->get();
                } else {
                    $response = Persona::select('Id', 'Nombre')->where('Activo', '=', 1)->where('Socio', '=', 1)->get();
                }
            }
        } catch (Exception $e) {
            $response = Persona::select('Id', 'Nombre')->where('Id', '=', 1)->get();
        }

        return $response;
    }

    public function getRecibos($id)
    {
        $solicitud = Solicitud::join('persona as solicitante', 'solicitud.Solicitante', '=', 'solicitante.Id')
                ->join('banco', 'solicitante.Banco', '=', 'banco.Id')
                ->join('tipo', 'solicitud.Tipo', '=', 'tipo.Id')
                ->join('estado', 'solicitud.Estado', '=', 'estado.Id')
                ->select(
                    'solicitud.id',
                    'solicitud.numero',
                    DB::raw("DATE_FORMAT(solicitud.fecha, '%d/%m/%Y') as fecha"),
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
                ->where('solicitud.Id','=',$id)
                ->orderBy('solicitud.Numero', 'desc')
                ->first();
        try {

            $recibos = Recibo::select(
                DB::raw("DATE_FORMAT(Fecha, '%d/%m/%Y') as Fecha"),
                'id',
                'Numero',
                'Pago',
                'Interes',
                'Capital',
                DB::raw('Total as Saldo')
            )
            ->where('Solicitud','=',$id)
            ->orderBy('Numero','desc')
            ->get();
            $response = ["val"=>1,"recibos"=>$recibos,"solicitud"=>$solicitud];
        } catch (Exception $e) {
            $response = ["val"=>0,"recibos"=>null,"solicitud"=>null];
        }

        return $response;
    }
    public function AddRecibo($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $recibos = Recibo::where('Solicitud', '=', $id)->get();
        $interes = 0;
        $capital = 0;

        $fecha_final = Carbon::now('America/El_Salvador');

        if ($recibos->count() > 0) {
            $last_recibo = Recibo::where('Solicitud', '=', $id)->orderBy('Id', 'desc')->first();

            $fecha_inicio = Carbon::parse(substr($last_recibo->Fecha, 0, 8) . '01');
            $fecha_final = Carbon::parse($fecha_final->format('Y-m-') . '01');
            $meses = $fecha_inicio->diffInMonths($fecha_final);

            if ($meses == 0 && $last_recibo->Capital > 0) {
                $capital = $last_recibo->Total;
                $interes = 0.00;
            } else {


                for ($i = 1; $i <= $meses; $i++) {
                    if ($i == 1) {
                        $capital = $last_recibo->Total;
                        $interes = $capital * ($solicitud->Tasa / 100);
                        if ($meses != 1) {
                            $capital = $capital + $interes;
                        }
                    } else {
                        $interes = $capital * ($solicitud->Tasa / 100);
                        if ($i < $meses) {
                            $capital = $capital + $interes;
                        }
                    }
                    //echo $capital . '   ' . $interes . '<br>';
                }
            }

            //return view('control.solicitud.edit', compact('capital', 'interes', 'personas', 'solicitud', 'recibos', 'interes'));
        } else {
            $fecha_inicio = Carbon::parse($solicitud->Fecha);
            $now = Carbon::now('America/El_Salvador');
            $fechafinal = Carbon::parse($now->format('Y-m-') . '03');
            $meses = $fecha_inicio->diffInMonths($fechafinal);

            $meses++;
            $capital = $solicitud->Monto;
            $capital_temporal = $solicitud->Monto;
            for ($i = 1; $i <= $meses; $i++) {
                if ($i == 1) {

                    $interes = $capital_temporal * ($solicitud->Tasa / 100);
                    if ($meses != 1) {
                        $capital_temporal = $capital_temporal + $interes;
                    }
                } else {
                    $interes = $capital_temporal * ($solicitud->Tasa / 100);
                    if ($i < $meses) {
                        $capital_temporal = $capital_temporal + $interes;
                    }
                }
            }

            $capital = $capital_temporal;
        }

        $response = ["monto"=>$capital,"interes"=>$interes,"solicitud"=>$solicitud->Numero,"solicitud_monto"=>$solicitud->Monto];

        return $response;
    }

    public function store(Request $request)
    {

        try {
            $max_numero = Solicitud::max('Numero');
            $max_credito = Solicitud::max('NumeroCredito');
            $data = $request->json()->all();

            $max_numero = Solicitud::max('Numero');
            $max_credito = Solicitud::max('NumeroCredito');
            $solicitud = new Solicitud();
            $solicitud->Numero = $max_numero + 1;
            $solicitud->Fecha = $data['Fecha'];
            $solicitud->Solicitante = $data['Solicitante'];
            $solicitud->Cantidad = $data['Cantidad'];
            $solicitud->Monto = $data['Cantidad'];
            $solicitud->Tipo = 1;
            $solicitud->Tasa = 4;
            $solicitud->Meses = $data['Meses'];
            $solicitud->NumeroCredito = $max_credito + 1;
            if ($data['Fiador'] != "") {
                $solicitud->Fiador = $data['Fiador'];
            } else {
                $solicitud->Fiador = 1;
            }
            $solicitud->Estado = 2;
            $time = Carbon::now('America/El_Salvador');
            $solicitud->FechaIngreso =  $time->toDateTimeString();
            $solicitud->save();

            return response()->json(['value' => "1", 'message' => "Registro ingresado correctamente"]);
        } catch (Exception $e) {
            return response()->json(['value' => "0", 'message' => "Error al  ingresar registro"]);
        }

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

        ], $messages);*/



        /*
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
        }*/
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitantes = Persona::where('Activo', '=', 1)->where('Id', '>', 1)->get();
        $fiadores = Persona::where('Activo', '=', 1)->where('Socio', '=', 1)->get();
        $tipos = Tipo::get();
        $recibos = Recibo::where('Solicitud', '=', $id)->get();

        $response = ["solicitud" => $solicitud, "solicitantes" => $solicitantes, "fiadores" => $fiadores, "tipos" => $tipos, "recibos" => $recibos];

        return $response;
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
        try {
            $solicitud = Solicitud::findOrFail($id);
            $solicitud->Fecha = $request->Fecha;
            $solicitud->Solicitante = $request->Solicitante;
            $solicitud->Monto = $request->Monto;
            $solicitud->Meses = $request->Meses;
            $solicitud->Tipo = $request->Tipo;
            $solicitud->update();

            return response()->json(['value' => "1", 'message' => "Registro ingresado correctamente"]);
        } catch (Exception $e) {
            return response()->json(['value' => "0", 'message' => "Error al  ingresar registro"]);
        }
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
