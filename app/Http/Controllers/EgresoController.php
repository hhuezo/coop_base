<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Rubro;
use App\Models\Tipo;
use App\Models\Usuario;
use Illuminate\Http\Request;

class EgresoController extends Controller
{

    public function index()
    {
        //
        //la variable jala el modelo , nombre exacto
        $egresos = Egreso::get();
        //dd($egresos); //(verificar los datos de la variable)
        //en compact va el nombre de la variable $banco sin el signo dollar
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
            'Numero' => 'required',
            'Fecha' => 'required',
            'Descripcion' => 'required',
            'Tipo' => 'required',
            'Cantidad' => 'required',
            'Rubro' => 'required',
            'Usuario' => 'required',
            'FechaIngreso' => 'required',
        ], $messages);
        //creamos un nuevo registro en la tabla banco, llamando el modelo banco.
        $egresos = new Egreso();
        //asignando el valor del formulario al campo de la tabla
        $egresos->Numero = $request->Numero;
        $egresos->Fecha = $request->Fecha;
        $egresos->Descripcion = $request->Descripcion;
        $egresos->Tipo = $request->Tipo;
        $egresos->Cantidad = $request->Cantidad;
        $egresos->Rubro = $request->Rubro;
        $egresos->Usuario = $request->Usuario;
        $egresos->FechaIngreso = $request->FechaIngreso;
        //guardamos
        $egresos->save();
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
        $egresos->Usuario = $request->Usuario;
        $egresos->FechaIngreso = $request->FechaIngreso;

        //guardamos
        $egresos->update();
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
