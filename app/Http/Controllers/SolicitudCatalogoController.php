<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Persona;
use App\Models\Recibo;
use App\Models\Solicitud;
use App\Models\Tipo;
use Illuminate\Http\Request;

class SolicitudCatalogoController extends Controller
{
    public function index()
    {
        //
        $solicitudes = Solicitud::get();
        //  dd($solicitudes); //(verificar los datos de la variable)
        return view('solicitud.index', compact('solicitudes'));
    }


    public function create()
    {
        //
        $tipo = Tipo::get();
        $estados = Estado::get();
        $personas = Persona::where('Id', '>', 1)->get();
        $fiadores = Persona::where('Socio', '=', 1)->get();
        // SE AGREGA LA VISTA DE SOLICITUD.CREATE JUNTO A LOS DATOS DE LATABLAS RELACIONADAS
        return view('solicitud.create', compact('tipo', 'estados', 'personas', 'fiadores'));
    }


    public function store(Request $request)
    {
        //
        $messages = [
            'Numero.required' => 'El Numero de Egreso es un valor requerido',
            'Fecha.required' => 'Fecha es un valor requerido',
            'Solicitante.required' => 'Solicitante es un valor requerido',
            'Cantidad.required' => 'Cantidad es un valor requerido',
            'Monto.required' => 'El monto es un valor requerido',
            'Tipo.required' => 'Tipo es un valor requerido',
            'Tasa.required' => 'La Tasa es un valor requerido',
            'Meses.required' => 'El Mese es un valor requerido',
            'NumeroCredito.required' => 'El Numero de Credito es un valor requerido',
            'Estado.required' => 'El Estado es un valor requerido',
            'UsuarioIngreso.required' => 'El Usuario que Ingreso es un valor requerido',
            'FechaIngreso.required' => 'La Fecha de Ingreso es un valor requerido',
            'UsuarioAprobacion.required' => 'El Usuario que Aprobo es un valor requerido',
            'FechaAprobacion.required' => 'La Fecha de Aprobacion es un valor requerido',
            'UsuarioAnulacion.required' => 'El Usuario que Anulao es un valor requerido',
            'FechaAnulacion.required' => 'La Fecha de Anulacion es un valor requerido',
        ];
        $request->validate([
            'Numero' => 'required',
            'Fecha' => 'required',
            'Solicitante' => 'required',
            'Cantidad' => 'required',
            'Monto' => 'required',
            'Tipo' => 'required',
            'Tasa' => 'required',
            'Meses' => 'required',
            'NumeroCredito' => 'required',
            'Estado' => 'required',
            'UsuarioIngreso' => 'required',
            'FechaIngreso' => 'required',
            'UsuarioAprobacion' => 'required',
            'FechaAprobacion' => 'required',
            'UsuarioAnulacion' => 'required',
            'FechaAnulacion' => 'required',
        ], $messages);
        //creamos un nuevo registro en la tabla banco, llamando el modelo banco.
        $solicitudes = new Solicitud();
        //asignando el valor del formulario al campo de la tabla
        $solicitudes->Numero = $request->Numero;
        $solicitudes->Fecha = $request->Fecha;
        $solicitudes->Solicitante = $request->Solicitante;
        $solicitudes->Cantidad = $request->Cantidad;
        $solicitudes->Monto = $request->Monto;
        $solicitudes->Tipo = $request->Tipo;
        $solicitudes->Tasa = $request->Tasa;
        $solicitudes->Meses = $request->Meses;
        $solicitudes->NumeroCredito = $request->NumeroCredito;
        $solicitudes->Estado = $request->Estado;
        $solicitudes->UsuarioIngreso = $request->UsuarioIngreso;
        $solicitudes->FechaIngreso = $request->FechaIngreso;
        $solicitudes->UsuarioAprobacion = $request->UsuarioAprobacion;
        $solicitudes->FechaAprobacion = $request->FechaAprobacion;
        $solicitudes->UsuarioAnulacion = $request->UsuarioAnulacion;
        $solicitudes->FechaAnulacion = $request->FechaAnulacion;
        //guardamos
        $solicitudes->save();
        return redirect('solicitud');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $solicitudes = Solicitud::findOrFail($id);
        $tipo = Tipo::get();
        $estados = Estado::get();
        $personas = Persona::get();
        $fiadores = Persona::where('Socio', '=', 1)->get();
        // PRIMER PARAMETRO CAMPO DE LA CONSULTA A COMPARAR EN LA TABLA RELACIONADA SEGUNDO PARAMETRO LLAVE DE LA TABLA SOLCITUD
        $recibos = Recibo::where('Solicitud', '=', $id)->get();

        //dd($estado);
        return view('solicitud.edit', compact('tipo', 'estados', 'personas', 'solicitudes', 'recibos', 'fiadores'));
    }


    public function update(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        //asignando el valor del formulario al campo de la tabla
        $solicitud->Numero = $request->Numero;
        $solicitud->Fecha = $request->Fecha;
        $solicitud->Solicitante = $request->Solicitante;
        //$solicitud->Cantidad = $request->Cantidad;
        $solicitud->Monto = $request->Monto;
        $solicitud->Tipo = $request->Tipo;
        $solicitud->Tasa = $request->Tasa;
        $solicitud->Meses = $request->Meses;
        $solicitud->Fiador = $request->Fiador;
        //$solicitud->NumeroCredito = $request->NumeroCredito;
        $solicitud->Estado = $request->Estado;
        // $solicitud->UsuarioIngreso = $request->UsuarioIngreso;
        // $solicitud->FechaIngreso = $request->FechaIngreso;
        // $solicitud->UsuarioAprobacion = $request->UsuarioAprobacion;
        // $solicitud->FechaAprobacion = $request->FechaAprobacion;
        // $solicitud->UsuarioAnulacion = $request->UsuarioAnulacion;
        // $solicitud->FechaAnulacion = $request->FechaAnulacion;

        //guardamos
        $solicitud->update();
        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }


    public function destroy($id)
    {
        //
        $solicitudes = Solicitud::findOrFail($id);
        $solicitudes->delete();
        //te regresa a la pagina donde estas, no necesariamente index.
        return back();
    }
}
