@extends ('welcome')

@section('contenido')

    <div class="x_panel">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Nuevo Rubro<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">

                    </ul>
                    <div class="clearfix"></div>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- AQUI EMPIEZA EL CODIGO DE CREACION DE NUEVO REGISTRO --}}

                <div class="x_content">
                    <br />
                    {{-- metodo post porque es para guardar los datos --}}
                    {{-- rubro es la ruta --}}
                    <form action="{{ url('rubro') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="text" name="Nombre" class="form-control" autofocus="true"
                                    value="{{ old('Nombre') }}" required="true"
                                    onblur="this.value = this.value.toUpperCase()">
                            </div>
                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Activo</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="number" name="Activo" class="form-control" autofocus="true" required="true"
                                    onblur="this.value = this.value.toUpperCase()">
                            </div>
                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        {{-- AQUI SE AGREGA EL CODIGO PARA PRESENTAR EL NOMBRE DEL TIPO, CAMPO RELACIONADO ENTRE RUBRO Y TIPO --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipo</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{--  --}}
                                <select name="Tipo" class="form-control">
                                    @foreach ($tipo as $obj)
                                        <Option value="{{ $obj->Id }}">
                                            {{ $obj->Nombre }}
                                        </Option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>
                        <div class="form-group" align="center">
                            <button class="btn btn-success" type="submit">Guardar</button>
                            <a href="{{ url('rubro') }}"><button class="btn btn-primary"
                                    type="button">Cancelar</button></a>
                        </div>

                    </form>
                </div>



            </div>

        </div>
    </div>
    </div>
@endsection
