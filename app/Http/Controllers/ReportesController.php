<?php

namespace App\Http\Controllers;

use App\Models\TempIngresos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function ingresos()
    {
        return view('reportes.ingresos');
    }

    public function ingresos_generar(Request $request)
    {
        $FechaInicio = $request->FechaInicio;
        $FechaFinal = $request->FechaFinal;

        TempIngresos::truncate();

        $result = DB::table('solicitud')
            ->select(
                DB::raw('ifnull(sum(Monto),0) as totalMonto'),
                DB::raw('(select ifnull(sum(Cantidad),0) from egreso where Fecha < "' . $FechaInicio . '" and Tipo = 2) as totalCantidad')
            )
            ->whereIn('Estado', [2, 3])
            ->where('Fecha', '<', $FechaInicio)
            ->first();

        $total_egresos = $result->totalMonto + $result->totalCantidad;


        $result = DB::table('aportaciones')
            ->select(
                DB::raw('ifnull(sum(Cantidad),0) as totalCantidad'),
                DB::raw('(select ifnull(sum(Cantidad),0) from egreso where Fecha < "' . $FechaInicio . '" and Tipo = 1) as totalCantidadEgreso'),
                DB::raw('(select ifnull(sum(Pago),0) from recibo where recibo.Fecha < "' . $FechaInicio . '") as totalPago')
            )
            ->where('Fecha', '<', $FechaInicio)
            ->first();
        $total_ingresos = $result->totalCantidad + $result->totalCantidadEgreso + $result->totalPago;
        //dd($result->totalCantidad , $result->totalCantidadEgreso , $result->totalPago);
        $monto_inicial = $total_ingresos - $total_egresos;

        $temp = new TempIngresos();
        $temp->Tipo = 1;
        $temp->Fecha = $FechaInicio;
        $temp->Descripcion = 'MONTO INICIAL';
        $temp->Ingreso = $monto_inicial;
        $temp->Total = $monto_inicial;
        $temp->save();



        $results = DB::table('persona')
            ->join('aportaciones', 'persona.Id', '=', 'aportaciones.Socio')
            ->select('aportaciones.Id', 'aportaciones.Fecha', 'persona.Nombre', 'aportaciones.Cantidad')
            ->whereBetween('aportaciones.Fecha', [$FechaInicio, $FechaFinal])
            ->get();



        foreach ($results as $obj) {
            $temp = new TempIngresos();
            $temp->Tipo = 1;
            $temp->Fecha = $obj->Fecha;
            $temp->Descripcion = 'APORTACION (' . $obj->Nombre . ')';
            $temp->Ingreso = $obj->Cantidad;
            $temp->save();
        }

        $results = DB::table('solicitud')
            ->join('recibo', 'solicitud.Id', '=', 'recibo.Solicitud')
            ->join('persona', 'persona.Id', '=', 'solicitud.Solicitante')
            ->select('recibo.Id', 'recibo.Fecha', 'persona.Nombre', 'recibo.Interes', 'recibo.Capital')
            ->whereBetween('recibo.Fecha', [$FechaInicio, $FechaFinal])
            ->get();



        foreach ($results as $obj) {
            $temp = new TempIngresos();
            $temp->Tipo = 1;
            $temp->Fecha = $obj->Fecha;
            $temp->Descripcion = 'ABONO A CAPITAL (' . $obj->Nombre . ')';
            $temp->Ingreso = $obj->Capital;
            $temp->save();

            $temp = new TempIngresos();
            $temp->Tipo = 1;
            $temp->Fecha = $obj->Fecha;
            $temp->Descripcion = 'PAGO DE INTERES (' . $obj->Nombre . ')';
            $temp->Ingreso = $obj->Interes;
            $temp->save();
        }

        $results = DB::table('persona')
            ->join('solicitud', 'persona.Id', '=', 'solicitud.Solicitante')
            ->select('solicitud.Id', 'solicitud.Numero', 'solicitud.Fecha', 'persona.Nombre', 'solicitud.Monto')
            ->whereBetween('solicitud.Fecha', [$FechaInicio, $FechaFinal])
            ->get();


        foreach ($results as $obj) {
            $temp = new TempIngresos();
            $temp->Tipo = 2;
            $temp->Fecha = $obj->Fecha;
            $temp->Descripcion = 'PRESTAMO SOLICITUD: ' . $obj->Numero . '(' . $obj->Nombre . ')';
            $temp->Egreso = $obj->Monto;
            $temp->save();
        }

        $results = DB::table('egreso')
            ->select('Id', 'Fecha', 'Descripcion', 'Tipo', 'Cantidad')
            ->whereBetween('Fecha', [$FechaInicio, $FechaFinal])
            ->get();
        foreach ($results as $obj) {
            if ($obj->Tipo == 1) {
                $temp = new TempIngresos();
                $temp->Tipo = 1;
                $temp->Fecha = $obj->Fecha;
                $temp->Descripcion = $obj->Descripcion;
                $temp->Ingreso = $obj->Cantidad;
                $temp->save();
            } else {
                $temp = new TempIngresos();
                $temp->Tipo = 2;
                $temp->Fecha = $obj->Fecha;
                $temp->Descripcion = $obj->Descripcion;
                $temp->Egreso = $obj->Cantidad;
                $temp->save();
            }
        }


        $result_inicial = DB::table('temp_ingreso_egreso')
            ->select('Tipo', 'Fecha', 'Descripcion', 'Ingreso', 'Egreso', 'Total')
            ->where('Id', '=', 1)
            ->first();

        $results = DB::table('temp_ingreso_egreso')
            ->select('Tipo', 'Fecha', 'Descripcion', 'Ingreso', 'Egreso', 'Total')
            ->where('Id', '>', 1)
            ->orderBy('Fecha')
            ->orderBy('Id')
            ->get();

        return view('reportes.ingresos_aceptar', compact('FechaInicio', 'FechaFinal', 'result_inicial', 'results'));
    }
}
