<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Mail\ReciboMail;
use App\Mail\VerificacionMail;
use App\Models\Banco;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\Recibo;
use App\Models\Solicitud;
use App\Models\Tipo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use NumberFormatter;

class SolicitudController extends Controller
{

    public function index()
    {
        $solicitudes = Solicitud::get();
        return view('control.solicitud.index', compact('solicitudes'));
    }

    public function create_persona(Request $request)
    {
        $persona = new Persona();
        $persona->Nombre = $request->Nombre;
        $persona->Dui = $request->Dui;
        $persona->Nit = $request->Nit;
        $persona->Telefono = $request->Telefono;
        $persona->Correo = $request->Correo;
        $persona->Socio = 0;
        $persona->Banco = $request->Banco;
        $persona->NumeroCuenta = $request->NumeroCuenta;
        $persona->Activo = 1;
        $persona->save();

        $personas = Persona::where('Activo', '=', 1)->get();
        return $personas;
    }

    public function create()
    {
        $tipo = Tipo::get();
        $estados = Estado::get();
        $personas = Persona::where('Id', '>', 1)->get();
        $fiadores = Persona::where('Socio', '=', 1)->get();
        $bancos = Banco::get();
        return view('control.solicitud.create', compact('tipo', 'estados', 'personas', 'fiadores', 'bancos'));
    }

    public function reporte_solicitud($id, $opcion)
    {
        $meses = array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
        $solicitud = Solicitud::findOrFail($id);

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
                "solicitud" => $solicitud, "meses" => $meses, "tabla_amortizacion" => $tabla_amortizacion, "mes" => $mes, "cuotaMensual" => $cuotaMensual,
                "solicitud" => $solicitud
            ]
        );

        if ($opcion == 1) {
            return $pdf->download('solicitud.pdf');
        }



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
        alert()->success('El correo ha sido enviado correctamente');

        return back();


        // //return $pdf->download('ejemplo.pdf');


    }





    public function get_fiador($id)
    {
        $response = 0;
        $persona = Persona::findOrFail($id);
        if ($persona) {
            if ($persona->Socio == 1) {
                $response = 1;
            } else {
                $response = 0;
            }
        }

        return $response;
    }

    public function store(Request $request)
    {
        $messages = [

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
        return back();
    }


    public function show($id)
    {
        //
    }



    public function calculo_recibo($id, $fecha)
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


        $response = ["Capital" => $capital, "Interes" => $interes];

        return $response;
        /* $interes = 0;
        $capital = 0;
        $fecha_final = Carbon::parse($fecha);

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
                }
            }
            $response = ["Capital" => $capital, "Interes" => $interes];
        } else {
            $fecha_inicio = Carbon::parse($solicitud->Fecha);

            $now = Carbon::now('America/El_Salvador');
            $fechafinal = Carbon::parse($fecha);
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
                //echo $capital_temporal . '   ' . $interes . '<br>';
            }

            //$capital = round($capital_temporal , 2);

            $response = ["Capital" => $capital_temporal, "Interes" => $interes];
        }


        return $response;*/
    }

    public function calculoMes($fecha_inicio, $fecha_final)
    {
        $inicio = Carbon::parse($fecha_inicio);
        $final = Carbon::parse($fecha_final);
        $fecha_evaluar_inicio = Carbon::parse($fecha_inicio);

        // Verificar si el año y el mes son iguales
        if ($inicio->format('Y-m') == $final->format('Y-m')) {
            return 1;
        }

        // Ajustar para asegurarse de que las fechas estén en el primer día del mes
        $inicio = $inicio->firstOfMonth();
        $final = $final->firstOfMonth();

        // Calcular el número de meses afectados
        $mesesAfectados = $final->diffInMonths($inicio);

        if ($fecha_evaluar_inicio->day < 22) {
            // Asegurarse de contar el mes inicial
            $mesesAfectados += 1;
        }

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


    public function edit($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $personas = Persona::get();
        $fecha_final = Carbon::now('America/El_Salvador');
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




        //dd($deuda, $capital,  $interes);
        return view('control.solicitud.edit', compact('capital', 'interes', 'personas', 'solicitud', 'recibos'));

    }


    public function reporte_recibo($id, $opcion)
    {
        $recibo = Recibo::findOrFail($id);
        $meses = array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");

        $mes_int = substr($recibo->Fecha, 5, 2) + 0;

        $mes = $meses[$mes_int];

        $formatter = new  NumberFormatter('es', NumberFormatter::SPELLOUT);

        $numero = intval($recibo->Pago);
        $cantidad = strtoupper($formatter->format($numero));
        $decimal = number_format($recibo->Pago - floor($recibo->Pago), 2);

        $pdf = \PDF::loadView(
            'reportes.recibo',
            ["recibo" => $recibo, "mes" => $mes, "cantidad" => $cantidad, "decimal" => $decimal]
        );

        if ($opcion == 1) {
            return $pdf->download('recibo.pdf');
        }

        try {
            unlink(public_path('recibo.pdf'));
        } catch (Exception $e) {
            //print "whoops!";
            //or even leaving it empty so nothing is displayed
        }

        try {

            $pdf->save(public_path('recibo.pdf'));

            $subject = 'Acoesi de RL, pago registrado';
            $content = "Estimad@ : " . $recibo->solicitud->persona->Nombre . ",  Por este medio deseamos informale que se ha registrado satisfactoriamente su pago el cual se detalla en el archivo adjunto";
            $recipientEmail = $recibo->solicitud->persona->Correo;
            $file = public_path('recibo.pdf');
            // dd($recipientEmail);
            Mail::to($recipientEmail)->send(new ReciboMail($subject, $content, $file));
            alert()->success('El correo ha sido enviado correctamente');
        } catch (Exception $e) {
            alert()->error('El correo no ha sido enviado correctamente');
        }

        return back();


        //return view('reportes.recibo', ["recibo" => $recibo, "mes" => $mes, "cantidad" => $cantidad, "decimal" => $decimal]);
    }


    public function recibo_nuevo(Request $request)
    {
        $max_numero = Recibo::max('Numero');
        $recibo = new Recibo();
        $recibo->Fecha = $request->Fecha;
        $recibo->Solicitud = $request->Solicitud;
        $recibo->Numero = $max_numero + 1;
        $recibo->Pago = $request->Pago;
        if ($request->Pago <= $request->Interes) {
            $recibo->Interes = $request->Pago;
            $recibo->Capital = 0;
        } else {
            $recibo->Interes = $request->Interes;
            $recibo->Capital = $request->Pago - $request->Interes;
        }

        $recibo->CantidadActual = $request->Pago;

        $recibo->Total = ($request->Monto + $request->Interes) - $request->Pago;
        $recibo->Usuario = $request->Usuario;
        $time = Carbon::now('America/El_Salvador');
        $recibo->FechaInicio =  $time->toDateTimeString();
        $recibo->Usuario = auth()->user()->id;


        if (($request->Monto + $request->Interes) == $request->Pago) {
            $solicitud = Solicitud::findOrFail($request->Solicitud);
            $solicitud->Estado = 3;
            $solicitud->update();
        }


        //guardamos
        $recibo->save();

        try {



            if ($recibo->solicitud->persona->Correo) {
                $meses = array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");

                $mes_int = substr($recibo->Fecha, 5, 2) + 0;

                $mes = $meses[$mes_int];

                $formatter = new  NumberFormatter('es', NumberFormatter::SPELLOUT);

                $numero = intval($recibo->Pago);
                $cantidad = strtoupper($formatter->format($numero));
                $decimal = number_format($recibo->Pago - floor($recibo->Pago), 2);

                $pdf = \PDF::loadView(
                    'reportes.recibo',
                    ["recibo" => $recibo, "mes" => $mes, "cantidad" => $cantidad, "decimal" => $decimal]
                );

                try {
                    unlink(public_path('recibo.pdf'));
                } catch (Exception $e) {
                    //print "whoops!";
                    //or even leaving it empty so nothing is displayed
                }

                $pdf->save(public_path('recibo.pdf'));

                $subject = 'Acoesi de RL, pago registrado';
                $content = "Estimad@ : " . $recibo->solicitud->persona->Nombre . ",  Por este medio deseamos informale que se ha registrado satisfactoriamente su pago el cual se detalla en el archivo adjunto";
                $recipientEmail = $recibo->solicitud->persona->Correo;
                $file = public_path('recibo.pdf');
                // dd($recipientEmail);
                Mail::to($recipientEmail)->send(new ReciboMail($subject, $content, $file));
            }
        } catch (Exception $e) {
            //;
            //or even leaving it empty so nothing is displayed
        }
        alert()->success('El registro ha sido creado correctamente');
        return back();
    }



    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        //
    }
}
