<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
   
    public function index()
    {
        //
        $estados = Estado::get();
        //dd($estados); (verificar los datos de la variable)
        return view('estado.index',compact('estados'));

    }

    
    public function create()
    {
        //
        return view('estado.create');
    }

   
    public function store(Request $request)
    {
        //
        // dd(''); para probar si llegas a la ruta
        $messages = [
            'Nombre.required' => 'El nombre es un valor requerido'
        ];
        $request->validate(['Nombre' => 'required'], $messages);
        //creamos un nuevo registro en la tabla estado, llamando el modelo estado.
        $estado = new Estado();
        //asignando el valor del formulario al camo de la tabla
        $estado->Nombre = $request->Nombre;
        //guardamos
        $estado->save();
        return redirect('estado');
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
        $estado = Estado::findOrFail($id);
        //dd($estado);
        return view('estado.edit',compact('estado'));
    }

    
    public function update(Request $request, $id)
    {
        //  dd('');
        $messages = [
            'Nombre.required' => 'El nombre es un valor requerido'
        ];
        $request->validate(['Nombre' => 'required'], $messages);
        $estado = Estado::findOrFail($id);
        //dd($estado);
        $estado->Nombre = $request->Nombre;
        //guardamos
        $estado->update();
        return redirect('estado');

    }

    
    public function destroy($id)
    {
        //
        //dd($id);
        $estado = Estado::findOrFail($id);
        $estado->delete();
        //te regresa a la pagina donde estas, no necesariamente index.
        return back();
    }
}
