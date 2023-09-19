<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{

    public function index()
    {

        $persona = Persona::get();

        return view('persona.index', compact('persona'));
    }

    public function get_banco($id)
    {
        $persona = Persona::findOrFail($id);
        return $persona->ObjBanco->Nombre;
    }

    public function get_dui($id)
    {
        $persona = Persona::findOrFail($id);
        return $persona->Dui;
    }

    public function create()
    {
        //
        $bancos = Banco::get();
        return view('persona.create', compact('bancos'));
    }


    public function store(Request $request)
    {

        $messages = [
            'Nombre.required' => 'El nombre de la Persona es un valor requerido',
            'Dui.required' => 'El nombre del Dui es un valor requerido',
            'Cuenta.required' => 'La cuenta es un valor requerido'
        ];
        $request->validate([
            'Nombre' => 'required',
            'Dui' => 'required',
            //'Cuenta' => 'required'

        ], $messages);

        $persona = new Persona();
        $persona->Nombre = $request->Nombre;
        $persona->Dui = $request->Dui;
        $persona->Nit = $request->Nit;
        $persona->Telefono = $request->Telefono;
        $persona->Correo = $request->Correo;
        if($request->Socio == null)
        {
            $persona->Socio = 0;
        }else{
            $persona->Socio = 1;
        }
        $persona->Banco = $request->Banco;
        $persona->NumeroCuenta = $request->NumeroCuenta;
        $persona->Activo = 1;


        //guardamos
        $persona->save();
        alert()->success('El registro ha sido guardado correctamente');
        return redirect('persona');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
        //
        $persona = Persona::findOrFail($id);
        $bancos = Banco::get();
        //dd($estado);
        return view('persona.edit', compact('persona', 'bancos'));
    }


    public function update(Request $request, $id)
    {
        //
        $persona = Persona::findOrFail($id);
        //asignando el valor del formulario al campo de la tabla
        $persona->Nombre = $request->Nombre;
        $persona->Dui = $request->Dui;
        $persona->Nit = $request->Nit;
        $persona->Telefono = $request->Telefono;
        $persona->Correo = $request->Correo;
        if($request->Socio == null)
        {
            $persona->Socio = 0;
        }else{
            $persona->Socio = 1;
        }
        $persona->Banco = $request->Banco;
        $persona->NumeroCuenta = $request->NumeroCuenta;
        if($request->Activo == null)
        {
            $persona->Activo = 0;
        }else{
            $persona->Activo = 1;
        }
        //guardamos
        $persona->update();
        alert()->success('El registro ha sido modificado correctamente');
        return redirect('persona');
    }


    public function destroy($id)
    {
        //
        //dd($id);
        $persona = Persona::findOrFail($id);
        $persona->delete();
        //te regresa a la pagina donde estas, no necesariamente index.
        return back();
    }
}
