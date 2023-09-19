@extends ('welcome')
@section('contenido')

    <div class="x_panel">
        <div class="clearfix"></div>

        {{-- CODIGO SOLO PARA EL ENCABEZADO --}}

        <div class="x_title">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h2>Listado de Personas</h2>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12" align="right">
                {{--  --}}
                <a href="{{ url('persona/create') }}"><button class="btn btn-info float-right"> <i class="fa fa-plus"></i>
                        Nuevo</button></a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>

        {{-- CODIGO PARA MOSTRAR EL LISTADO EN TABLA DEL CONTENIDO DE LA TABLA --}}


        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if ($persona->count() > 0)
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Dui</th>
                                <th>Nit</th>
                                <th>Telefono</th>
                                <th>Correo</th>
                                <th>Socio</th>
                                <th>Banco</th>
                                <th>Cuenta</th>
                                <th>Activo</th>

                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($persona as $obj)
                                <tr>
                                    <td align="center">{{ $obj->Id }}</td>
                                    <td>{{ $obj->Nombre }}</td>

                                    <td>{{ $obj->Dui }}</td>
                                    <td>{{ $obj->Nit }}</td>
                                    <td>{{ $obj->Telefono }}</td>
                                    <td>{{ $obj->Correo }}</td>
                                    <td>{{ $obj->Socio }}</td>
                                    {{-- AQUI SE AGREGA EL NOMBRE DE LA FUNCION DE LA RELACION QUE ESTA EN EL MODELO SEGUIDO DEL NOMBRE EXACTO DEL CAMPO --}}
                                    @if ($obj->banco)
                                        <td>{{ $obj->banco->Nombre }}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>{{ $obj->Cuenta }}</td>
                                    <td>{{ $obj->Activo }}</td>

                                    <td align="center">
                                        {{--  --}}
                                        <a href="{{ url('persona') }}/{{ $obj->Id }}/edit"
                                            class="on-default edit-row">
                                            <i class="fa fa-pencil fa-lg"></i></a>
                                        &nbsp;&nbsp;<a href="" data-target="#modal-delete-{{ $obj->Id }}"
                                            data-toggle="modal"><i class="fa fa-trash fa-lg"></i></a>
                                    </td>
                                </tr>
                                @include('persona.modal')
                            @endforeach
                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                @endif
            </div>



        </div>
    </div>

@endsection
