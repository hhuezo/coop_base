<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    
    public function index()
    {
        //la variable jala el modelo , nombre exacto
        $banco = Banco::get();
        //dd($banco); //(verificar los datos de la variable)
        //en compact va el nombre de la variable $banco sin el signo dollar
        return view('banco.index',compact('banco'));
    }

   
    public function create()
    {
        //
        return view('banco.create');
    }

    
    public function store(Request $request)
    {
        //
        //
        // dd(''); para probar si llegas a la ruta
        $messages = ['Nombre.required' => 'El nombre del Banco es un valor requerido'];
        $request->validate(['Nombre' => 'required'], $messages);
        //creamos un nuevo registro en la tabla banco, llamando el modelo banco.
        $banco = new Banco();
        //asignando el valor del formulario al campo de la tabla
        $banco->Nombre = $request->Nombre;
        //guardamos
        $banco->save();
        return redirect('banco');
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //no olvidar que Banco con B mayuscula corresponde al nombre del modelo.
        $banco = Banco::findOrFail($id);
        //dd($banco);
        return view('banco.edit',compact('banco'));

    }

    
    public function update(Request $request, $id)
    {
        //
        $messages = [
            'Nombre.required' => 'El nombre del Banco es un valor requerido'
        ];
        $request->validate(['Nombre' => 'required'], $messages);
        $banco = Banco::findOrFail($id);
        //dd($estado);
        //Nombre va con N mayuscula, porque asi se puso en el formulario edit.blade.php
        $banco->Nombre = $request->Nombre;
        //guardamos
        $banco->update();
        return redirect('banco');
    }

    
    public function destroy($id)
    {
        //
          //
        //dd($id);
        $banco = Banco::findOrFail($id);
        $banco->delete();
        //te regresa a la pagina donde estas, no necesariamente index.
        return back();
    }
}
