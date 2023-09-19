@extends ('welcome')
@section('contenido')

    <div class="x_panel">
        <div class="clearfix"></div>

        <div class="x_title">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h2>Listado de Solicitudes</h2>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12" align="right">
                <a href="{{ url('control/solicitud/create') }}"><button class="btn btn-info float-right"> <i
                            class="fa fa-plus"></i>
                        Nuevo</button></a>
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

                                <th>Numero</th>
                                <th>Fecha</th>
                                <th>Solicitante</th>
                                <th>Cuenta</th>
                                <th>Banco</th>
                                <th>Cantidad</th>
                                <th>Tasa</th>
                                <th>Meses</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitudes as $obj)
                                <tr>
                                    <td align="center">{{ $obj->Numero }}</td>
                                    <td>{{ date('d/m/Y', strtotime($obj->Fecha)) }}</td>
                                    <td>{{ $obj->persona->Nombre }}</td>
                                    <td>{{ $obj->persona->NumeroCuenta }}</td>
                                    @if ($obj->persona->banco)
                                        <td>{{ $obj->persona->banco->Nombre }}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>$ {{ $obj->Cantidad }}</td>
                                    <td> {{ $obj->Tasa }}</td>
                                    <td>{{ $obj->Meses }}</td>
                                    <td>{{ $obj->estado->Nombre }}</td>


                                    <td align="center">
                                        <a href="{{ url('control/solicitud') }}/{{ $obj->Id }}/edit"
                                            class="on-default edit-row">
                                            <i class="fa fa-pencil fa-lg"></i></a>

                                    </td>
                                </tr>
                                @include('control.solicitud.modal')
                            @endforeach
                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                @endif
            </div>
        </div>
    </div>
@endsection
