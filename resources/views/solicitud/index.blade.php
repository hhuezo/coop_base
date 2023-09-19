@extends ('welcome')
@section('contenido')
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="x_panel">
        <div class="clearfix"></div>

        <div class="x_title">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h2>Listado de Solicitudes</h2>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12" align="right">
                {{-- <a href="{{ url('solicitud/create') }}"><button class="btn btn-info float-right"> <i class="fa fa-plus"></i>
                        Nuevo</button></a> --}}
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if ($solicitudes->count() > 0)
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                {{-- <th>Id</th> --}}
                                <th>Numero</th>
                                <th>Fecha</th>
                                <th>Solicitante</th>
                                {{-- <th>Fiador</th> --}}
                                <th>Cantidad</th>
                                <th>Otorgado</th>
                                <th>Tipo</th>
                                <th>Tasa</th>
                                <th>Meses</th>
                                {{-- <th>Numero de Credito</th> --}}
                                <th>Estado</th>
                                {{-- <th>Usuario Ingreso</th>
                                <th>Fecha Ingreso</th>
                                <th>Usuario Aprobacion</th>
                                <th>Fecha de Aprobacion</th>
                                <th>Usuario Anulacion</th>
                                <th>Fecha de Anulacion</th> --}}
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitudes as $obj)
                                <tr>
                                    {{-- <td align="center">{{ $obj->Id }}</td> --}}

                                    <td>{{ $obj->Numero }}</td>
                                    <td>{{ date('d/m/Y', strtotime($obj->Fecha)) }}</td>
                                    <td>{{ $obj->persona->Nombre }}</td>
                                    {{-- <td>{{ $obj->Fiador }}</td> --}}
                                    <td>{{ $obj->Cantidad }}</td>
                                    <td>{{ $obj->Monto }}</td>
                                    <td>{{ $obj->tipo->Nombre }}</td>
                                    <td>{{ $obj->Tasa }}</td>
                                    <td>{{ $obj->Meses }}</td>
                                    {{-- <td>{{ $obj->NumeroCredito }}</td> --}}
                                    <td>{{ $obj->estado->Nombre }}</td>
                                    {{-- <td>{{ $obj->UsuarioIngreso }}</td>
                                    <td>{{ $obj->FechaIngreso }}</td>
                                    <td>{{ $obj->UsuarioAprobacion }}</td>
                                    <td>{{ $obj->FechaAprobacion }}</td>
                                    <td>{{ $obj->UsuarioAnulacion }}</td>
                                    <td>{{ $obj->FechaAnulacion }}</td> --}}


                                    <td align="center">
                                        <a href="{{ url('catalogo/solicitudes') }}/{{ $obj->Id }}/edit"
                                            class="on-default edit-row">
                                            <button class="btn btn-success"><i class="fa fa-pencil fa-lg"></i></button>

                                        </a>
                                        {{-- &nbsp;&nbsp;<a href="" data-target="#modal-delete-{{ $obj->Id }}"
                                            data-toggle="modal"><i class="fa fa-trash fa-lg"></i></a> --}}
                                    </td>
                                </tr>
                                @include('solicitud.modal')
                            @endforeach
                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                @endif
            </div>
        </div>
    </div>
@endsection
