@extends ('welcome')
@section('contenido')
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
<div class="x_panel">
    <div class="clearfix"></div>

    {{-- CODIGO SOLO PARA EL ENCABEZADO --}}

    <div class="x_title">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <h2>Listado de ingresos/egresos</h2>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12" align="right">
            {{--  --}}
            <a href="{{ url('egreso/create') }}"><button class="btn btn-info float-right"> <i class="fa fa-plus"></i> Nuevo</button></a>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>

    {{-- CODIGO PARA MOSTRAR EL LISTADO EN TABLA DEL CONTENIDO DE LA TABLA --}}


    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @if ($egresos->count() > 0)
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Fecha</th>
                        <th>Descripcion</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Rubro</th>
                        {{--  <th>Usuario</th>
                        <th>FechaIngreso</th>--}}
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($egresos as $obj)
                    <tr>
                        <td align="center">{{ $obj->Numero }}</td>
                        <td>{{ date('d/m/Y', strtotime($obj->Fecha)) }}</td>
                        <td>{{ $obj->Descripcion }}</td>
                        {{-- AQUI SE AGREGA EL NOMBRE DE LA FUNCION DE LA RELACION QUE ESTA EN EL MODELO SEGUIDO DEL NOMBRE EXACTO DEL CAMPO --}}
                        <td>{{ $obj->Tipo == 1 ? 'INGRESO':'EGRESO' }}</td>
                        <td>{{ $obj->Cantidad }}</td>
                        {{-- AQUI SE AGREGA EL NOMBRE DE LA FUNCION DE LA RELACION QUE ESTA EN EL MODELO SEGUIDO DEL NOMBRE EXACTO DEL CAMPO --}}
                        <td>{{ $obj->rubro->Nombre }}</td>
                        {{-- AQUI SE AGREGA EL NOMBRE DE LA FUNCION DE LA RELACION QUE ESTA EN EL MODELO SEGUIDO DEL NOMBRE EXACTO DEL CAMPO
                        <td>{{ $obj->usuario->Usuario}}</td>
                        <td>{{ $obj->FechaIngreso}}</td>--}}

                        <td align="center">

                            <a href="{{ url('egreso') }}/{{ $obj->Id }}/edit" class="on-default edit-row">
                               <button class="btn btn-success"> <i class="fa fa-pencil fa-lg"></i></button>
                            </a>
                             {{--   &nbsp;&nbsp;<a href="" data-target="#modal-delete-{{ $obj->Id }}"
                                    data-toggle="modal"><i class="fa fa-trash fa-lg"></i></a>--}}
                        </td>
                    </tr>
                    @include('egreso.modal')
                    @endforeach
                </tbody>
            </table>

            <div class="clearfix"></div>
            @endif
        </div>



    </div>
</div>

@endsection
