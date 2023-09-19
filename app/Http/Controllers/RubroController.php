<?php

namespace App\Http\Controllers;

use App\Models\Rubro;
use App\Models\Tipo;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    
    public function index()
    {
        //
        $rubros = Rubro::get();
        //dd($tipo);
        return view('rubro.index',compact('rubros'));
    }

   
    public function create()
    {
        //
       // SE AGREGA UNA VARIABLE PARA QUE ALMACENE LA INFO DE LA TABLA RELACIONADA TIPO.
        $tipo = Tipo::get();
        // SE AGREGA LA VISTA DE RUBRO.CREATE JUNTO A LOS DATOS DE LA TABLA RELACIONADA TIPO.
        return view('rubro.create', compact('tipo'));

    }

    
    public function store(Request $request)
    {
        //
         //
        // dd(''); para probar si llegas a la ruta
        $messages = ['Nombre.required' => 'El nombre de la Persona es un valor requerido',
        'Activo.required' => 'Activo es un valor requerido',
        'Tipo.required' => 'El Tipo de rubro es un valor requerido'
    ];
        $request->validate([
        'Nombre' => 'required',
        'Activo' => 'required',
        'Tipo' => 'required'
        ], $messages);
        //creamos un nuevo registro en la tabla banco, llamando el modelo banco.
        $rubros = new Rubro();
        //asignando el valor del formulario al campo de la tabla
        $rubros->Nombre = $request->Nombre;
        $rubros->Activo = $request->Activo;
        $rubros->Tipo = $request->Tipo;
        //guardamos
        $rubros->save();
        return redirect('rubro');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
        $rubros = Rubro::findOrFail($id);
        $tipo = Tipo::get();
        //dd($estado);
        return view('rubro.edit',compact('rubros','tipo'));
    }

   
    public function update(Request $request, $id)
    {
        //
         //
         $rubros = Rubro::findOrFail($id);
         //asignando el valor del formulario al campo de la tabla
         $rubros->Nombre = $request->Nombre;
         $rubros->Activo = $request->Activo;
         $rubros->Tipo = $request->Tipo;
         //guardamos
         $rubros->update();
         return redirect('rubro');
    }

    
    public function destroy($id)
    {
        //
          //dd($id);
          $rubros = Rubro::findOrFail($id);
          $rubros->delete();
          //te regresa a la pagina donde estas, no necesariamente index.
          return back();
    }
}
