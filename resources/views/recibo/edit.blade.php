@extends ('welcome')
@section('contenido')

    <div class="x_panel">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Modificacion de Egresos<small></small></h2>
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
                {{-- AQUI EMPIEZA EL CODIGO DE EDICION DE NUEVO REGISTRO --}}

                <form method="POST" action="{{ route('recibo.update', $recibos->Id) }}">
                    @method('PUT')
                    @csrf

                    <div class="x_content">
                        <br />
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Fecha</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="date" name="Fecha" class="form-control" autofocus="true"
                                        value="{{ $recibos->Fecha }}">
                                </div>
                            </div>

                            {{-- ESTA ES EL CODIGO PARA QUE APAREZCA EL DATO RELACIONADO QUE LE CORRESPONDE AL ID QUE SE VA A MODIFICAR  --}}
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Solicitud</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{-- ANALIZAR LENTAMENTE ESTE CODIGO DE SELECCION --}}
                                    <select name="Solicitud" class="form-control">
                                        @foreach ($solicitudes as $obj)
                                            @if ($obj->Id == $recibos->Solicitud)
                                                <Option value="{{ $obj->Id }}" selected>
                                                    {{ $obj->Numero }}

                                                </Option>
                                            @else
                                                <Option value="{{ $obj->Id }}">
                                                    {{ $obj->Numero }}

                                                </Option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Numero</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="number" name="Numero" class="form-control" autofocus="true"
                                        value="{{ $recibos->Numero }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Pago</label>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="number" name="Pago" class="form-control" autofocus="true" step="0.01"
                                        value="{{ $recibos->Pago }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Interes</label>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="number" name="Interes" class="form-control" autofocus="true" step="0.01"
                                        value="{{ $recibos->Interes }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Cantidad Actual</label>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="number" name="CantidadActual" class="form-control" autofocus="true"  step="0.01"
                                        value="{{ $recibos->CantidadActual }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Capital</label>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="number" name="Capital" class="form-control" autofocus="true" step="0.01"
                                        value="{{ $recibos->Capital }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Total</label>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="number" name="Total" class="form-control" autofocus="true" step="0.01"
                                        value="{{ $recibos->Total }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Usuario</label>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="number" name="Usuario" class="form-control" autofocus="true"
                                        value="{{ $recibos->Usuario }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Fecha de Inicio</label>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="datetime-local" name="FechaInicio" class="form-control" autofocus="true"
                                        value="{{ $recibos->FechaInicio }}">
                                </div>
                            </div>

                            <div class="form-group" align="center">
                                <button class="btn btn-success" type="submit">Modificar</button>
                                <a href="{{ url('recibo') }}"><button class="btn btn-primary"
                                        type="button">Cancelar</button></a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
