<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Solicitud;
use App\Models\Tipo;
use Illuminate\Http\Request;

class ApiSolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('search')) {
            $solicitudes = Solicitud::join('persona as solicitante', 'solicitud.Solicitante', '=', 'solicitante.Id')
                ->join('banco', 'solicitante.Banco', '=', 'banco.Id')
                ->join('tipo', 'solicitud.Tipo', '=', 'tipo.Id')
                ->join('estado', 'solicitud.Estado', '=', 'estado.Id')
                ->select(
                    'solicitud.id',
                    'solicitud.numero',
                    'solicitud.fecha',
                    'solicitante.nombre',
                    'solicitante.numeroCuenta',
                    'banco.Nombre as banco',
                    'solicitud.monto',
                    'solicitud.cantidad',
                    'tipo.Nombre as tipo',
                    'solicitud.tasa',
                    'solicitud.meses',
                    'estado.Nombre as estado',
                    'estado.Id as id_estado'
                )->where('solicitante.Nombre', 'like', '%' . $request->get('search') . '%')
                ->orWhere('solicitud.Numero', 'like', '%' . $request->get('search') . '%')
                ->orderBy('solicitud.Numero', 'desc')
                ->get();
        } else {
            $solicitudes = Solicitud::join('persona as solicitante', 'solicitud.Solicitante', '=', 'solicitante.Id')
                ->join('banco', 'solicitante.Banco', '=', 'banco.Id')
                ->join('tipo', 'solicitud.Tipo', '=', 'tipo.Id')
                ->join('estado', 'solicitud.Estado', '=', 'estado.Id')
                ->select(
                    'solicitud.id',
                    'solicitud.numero',
                    'solicitud.fecha',
                    'solicitante.nombre',
                    'solicitante.numeroCuenta as cuenta',
                    'banco.Nombre as banco',
                    'solicitud.monto',
                    'solicitud.cantidad',
                    'tipo.Nombre as tipo',
                    'solicitud.tasa',
                    'solicitud.meses',
                    'estado.Nombre as estado',
                    'estado.Id as id_estado'
                )
                ->orderBy('solicitud.Numero', 'desc')
                ->get();
        }

        return $solicitudes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $solicitantes = Persona::where('Activo', '=', 1)->get();
        $fiadores = Persona::where('Activo', '=', 1)->where('Socio', '=', 1)->get();
        $tipos = Tipo::get();

        $response = ['solicitantes' => $solicitantes, 'fiadores' => $fiadores, 'tipos' => $tipos];

        return $response;
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
