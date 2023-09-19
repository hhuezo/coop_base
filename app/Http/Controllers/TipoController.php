<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    
    public function index()
    {
        //
        $tipo = Tipo::get();
        //dd($tipo);
        return view('tipo.index',compact('tipo'));
    }

   
    public function create()
    {
        //
        return view('tipo.create');
    }

    
    public function store(Request $request)
    {
        //
         // dd(''); para probar si llegas a la ruta
        $messages = [
            'Nombre.required' => 'El nombre es un valor requerido'
        ];
        $request->validate(['Nombre' => 'required'], $messages);
        //creamos un nuevo registro vacio en la tabla estado, llamando el modelo estado.
        $tipo = new Tipo();
        //asignamos los valor del formulario que estan en la variable y los mandamos a los campos de la tabla
        $tipo->Nombre = $request->Nombre;
        //guardamos
        $tipo->save();
        //regresamos al index
        return redirect('tipo');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
        $tipo = Tipo::findOrFail($id);
        //dd($tipo);
        return view('tipo.edit',compact('tipo'));
    }

   
    public function update(Request $request, $id)
    {
        //
        $messages = [
            'Nombre.required' => 'El nombre es un valor requerido'
        ];
        $request->validate(['Nombre' => 'required'], $messages);
        $tipo = Tipo::findOrFail($id);
        //dd($tipo);
        $tipo->Nombre = $request->Nombre;
        //guardamos
        $tipo->update();
        return redirect('tipo');
    }

    
    public function destroy($id)
    {
        //
        //
        //dd($id);
        $estado = Tipo::findOrFail($id);
        $estado->delete();
        //te regresa a la pagina donde estas, no necesariamente index.
        return back();
    }
}
