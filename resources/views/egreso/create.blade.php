@extends ('welcome')

@section('contenido')

    <div class="x_panel">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Nuevo ingreso/egreso<small></small></h2>
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
                    {{-- persona es la ruta? --}}
                    <form action="{{ url('egreso') }}" method="POST">
                        @csrf


                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipo</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="Tipo" class="form-control">
                                        <Option value="1">INGRESO</Option>
                                        <Option value="2">EGRESO</Option>
                                </select>
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Rubro</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="Rubro" class="form-control">
                                    @foreach ($rubros as $obj)
                                        <Option value="{{ $obj->Id }}">
                                            {{ $obj->Nombre }}
                                        </Option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="date" name="Fecha" value="{{ old('Fecha') }}" class="form-control"required="true">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cantidad</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="number" name="Cantidad" step="0.01" class="form-control" autofocus="true" required="true"
                                    onblur="this.value = this.value.toUpperCase()">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Descripcion</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="text" name="Descripcion" class="form-control"
                                    required="true" onblur="this.value = this.value.toUpperCase()">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>


                        <div class="form-group" align="center">
                            <button class="btn btn-success" type="submit">Guardar</button>
                            <a href="{{ url('egreso') }}"><button class="btn btn-primary"
                                    type="button">Cancelar</button></a>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
