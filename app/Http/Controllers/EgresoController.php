<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Rubro;
use App\Models\Tipo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EgresoController extends Controller
{

    public function index()
    {
        //
        //la variable jala el modelo , nombre exacto
        $egresos = Egreso::get();
        return view('egreso.index', compact('egresos'));
    }


    public function create()
    {
        //
        // $egresos = Egreso::get();
        //return view('egreso.create', compact('egresos'));

        // SE AGREGA UNA VARIABLE PARA QUE ALMACENE LA INFO DE LA TABLA RELACIONADA TIPO.
        $tipo = Tipo::get();
        $rubros = Rubro::get();
        $usuarios = Usuario::get();
        // SE AGREGA LA VISTA DE RUBRO.CREATE JUNTO A LOS DATOS DE LA TABLA RELACIONADA TIPO.
        return view('egreso.create', compact('tipo', 'rubros', 'usuarios'));
    }


    public function store(Request $request)
    {
        //
        // dd(''); para probar si llegas a la ruta
        $messages = [
            'Numero.required' => 'El Numero de Egreso es un valor requerido',
            'Fecha.required' => 'Fecha es un valor requerido',
            'Descripcion.required' => 'Descripcion es un valor requerido',
            'Tipo.required' => 'Tipo es un valor requerido',
            'Cantidad.required' => 'El monto es un valor requerido',
            'Rubro.required' => 'Rubro es un valor requerido',
            'Usuario.required' => 'El Usuario es un valor requerido',
            'FechaIngreso.required' => 'La Fecha de Ingreso es un valor requerido',
        ];
        $request->validate([
            'Fecha' => 'required',
            'Descripcion' => 'required',
            'Cantidad' => 'required',
            'Rubro' => 'required',
        ], $messages);

        $max = Egreso::max('Numero');

        $egresos = new Egreso();
        $egresos->Numero = $max +1;
        $egresos->Fecha = $request->Fecha;
        $egresos->Descripcion = $request->Descripcion;
        $egresos->Tipo = $request->Tipo;
        $egresos->Cantidad = $request->Cantidad;
        $egresos->Rubro = $request->Rubro;
        $egresos->Usuario = auth()->user()->id;
        $time = Carbon::now('America/El_Salvador');
        $egresos->FechaIngreso =  $time->toDateTimeString();
        //guardamos
        $egresos->save();
        alert()->success('El registro ha sido creado correctamente');
        return redirect('egreso');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
        $egresos = Egreso::findOrFail($id);
        $tipo = Tipo::get();
        $rubros = Rubro::get();
        $usuarios = Usuario::get();

        //dd($estado);
        return view('egreso.edit', compact('egresos', 'tipo', 'rubros', 'usuarios'));
    }


    public function update(Request $request, $id)
    {
        //
        $egresos = Egreso::findOrFail($id);
        //asignando el valor del formulario al campo de la tabla
        $egresos->Numero = $request->Numero;
        $egresos->Fecha = $request->Fecha;
        $egresos->Descripcion = $request->Descripcion;
        $egresos->Tipo = $request->Tipo;
        $egresos->Cantidad = $request->Cantidad;
        $egresos->Rubro = $request->Rubro;

        //guardamos
        $egresos->update();
        alert()->success('El registro ha sido modificado correctamente');
        return redirect('egreso');
    }


    public function destroy($id)
    {
        //
        //
        //dd($id);
        $egresos = Egreso::findOrFail($id);
        $egresos->delete();
        //te regresa a la pagina donde estas, no necesariamente index.
        return back();
    }
}
