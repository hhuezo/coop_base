<?php

namespace App\Http\Controllers;

use App\Models\Recibo;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class ReciboController extends Controller
{
   
    public function index()
    {
        //
        $recibos = Recibo::get();
        return view('recibo.index', compact('recibos'));
    }

   
    public function create()
    {
        $solicitudes = Solicitud::get();
        // SE AGREGA LA VISTA DE RUBRO.CREATE JUNTO A LOS DATOS DE LA TABLA RELACIONADA TIPO.
        return view('recibo.create', compact('solicitudes'));
    }
    

    
    public function store(Request $request)
    {
        //
        $messages = [
            'Fecha.required' => 'La Fecha de Egreso es un valor requerido',
            'Solicitud.required' => 'Solicitud es un valor requerido',
            'Numero.required' => 'Numero es un valor requerido',
            'Pago.required' => 'Pago es un valor requerido',
            'Interes.required' => 'El Interes es un valor requerido',
            'CantidadActual.required' => 'La Cantidad Actual es un valor requerido',
            'Capital.required' => 'El Capital es un valor requerido',
            'Total.required' => 'El Total es un valor requerido',
            'Usuario.required' => 'El Usuario es un valor requerido',
            'FechaInicio.required' => 'La Fecha de Inicio es un valor requerido',
        ];
        $request->validate([
            'Fecha' => 'required',
            'Solicitud' => 'required',
            'Numero' => 'required',
            'Pago' => 'required',
            'Interes' => 'required',
            'CantidadActual' => 'required',
            'Capital' => 'required',
            'Total' => 'required',
            'Usuario' => 'required',
            'FechaInicio' => 'required',
        ], $messages);
        //creamos un nuevo registro en la tabla banco, llamando el modelo banco.
        $recibos = new Recibo();
        //asignando el valor del formulario al campo de la tabla
        $recibos->Fecha = $request->Fecha;
        $recibos->Solicitud = $request->Solicitud;
        $recibos->Numero = $request->Numero;
        $recibos->Pago = $request->Pago;
        $recibos->Interes = $request->Interes;
        $recibos->CantidadActual = $request->CantidadActual;
        $recibos->Capital = $request->Capital;
        $recibos->Total = $request->Total;
        $recibos->Usuario = $request->Usuario;
        $recibos->FechaInicio = $request->FechaInicio;
        //guardamos
        $recibos->save();
        return redirect('recibo');
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
        $recibos = Recibo::findOrFail($id);
        $solicitudes = Solicitud::get();
        return view('recibo.edit', compact('solicitudes','recibos'));
    }

    
    public function update(Request $request, $id)
    {
        //
        //
        $recibos = Recibo::findOrFail($id);
        //asignando el valor del formulario al campo de la tabla
        $recibos->Fecha = $request->Fecha;
        $recibos->Solicitud = $request->Solicitud;
        $recibos->Numero = $request->Numero;
        $recibos->Pago = $request->Pago;
        $recibos->Interes = $request->Interes;
        $recibos->CantidadActual = $request->CantidadActual;
        $recibos->Capital = $request->Capital;
        $recibos->Total = $request->Total;
        $recibos->Usuario = $request->Usuario;
        $recibos->FechaInicio = $request->FechaInicio;

        //guardamos
        $recibos->update();
        return redirect('recibo');
    }

   
    public function destroy($id)
    {
        //
        $recibos = Recibo::findOrFail($id);
        $recibos->delete();
        //te regresa a la pagina donde estas, no necesariamente index.
        return back();
    }
}
