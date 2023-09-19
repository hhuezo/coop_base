@extends ('welcome')

@section('contenido')

    <div class="x_panel">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Nuevo Recibo<small></small></h2>
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
                    <form action="{{ url('recibo') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre exacto del campo --}}
                                <input type="date" name="Fecha" class="form-control" autofocus="true"
                                    value="{{ old('Fecha') }}" required="true">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                          {{-- AQUI SE AGREGA EL CODIGO PARA PRESENTAR EL NOMBRE DEL TIPO, CAMPO RELACIONADO ENTRE EGRESO-TIPO --}}
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Solicitud</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{--  --}}
                                <select name="Solicitud" class="form-control">
                                    @foreach ($solicitudes as $obj)
                                        <Option value="{{ $obj->Id }}">
                                            {{ $obj->Numero }}
                                        </Option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Numero</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="number" name="Numero" class="form-control" autofocus="true"
                                value="{{ old('Numero') }}" required="true">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pago</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="number" name="Pago" class="form-control" autofocus="true" required="true" step="0.01"
                                value="{{ old('Pago') }}">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Interes</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="number" name="Interes" value="{{ old('Interes') }}" step="0.01"
                                    class="form-control" autofocus="true" required="true">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cantidad Actual</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="number" name="CantidadActual" value="{{ old('CantidadActual') }}" step="0.01"
                                    class="form-control" autofocus="true" required="true">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Capital</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="number" name="Capital" value="{{ old('Capital') }}" step="0.01"
                                    class="form-control" autofocus="true" required="true">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Total</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="number" name="Total" value="{{ old('Total') }}" step="0.01"
                                    class="form-control" autofocus="true" required="true">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Usuario</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="number" name="Usuario" value="{{ old('Usuario') }}" 
                                    class="form-control" autofocus="true" required="true">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha de Inicio</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="datetime-local" name="FechaInicio" value="{{ old('FechaInicio') }}" 
                                    class="form-control" autofocus="true" required="true">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group" align="center">
                            <button class="btn btn-success" type="submit">Guardar</button>
                            <a href="{{ url('recibo') }}"><button class="btn btn-primary"
                                    type="button">Cancelar</button></a>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
