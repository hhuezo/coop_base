<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;

class ApiPersonaController extends Controller
{
    public function index()
    {
        try {
            $personas = Persona::join('banco','persona.Banco','=','banco.Id')
            ->select([
                'persona.Id as id',
                'persona.Nombre as nombre',
                'persona.Dui as dui',
                'persona.Nit as nit',
                'persona.Telefono as telefono',
                'persona.Correo as correo',
                'persona.Socio as socio',
                'banco.nombre as banco',
                'persona.NumeroCuenta as numeroCuenta',
                'persona.Activo as activo'
            ])->get();

            return response()->json([
                'success' => true,
                'data' => $personas
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
