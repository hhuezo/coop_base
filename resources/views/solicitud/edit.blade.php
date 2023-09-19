@extends ('welcome')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="x_panel">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Modificacion de Solicitudes<small></small></h2>
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

                <form method="POST" action="{{ route('solicitudes.update', $solicitudes->Id) }}">
                    @method('PUT')
                    @csrf

                    <div class="x_content">
                        <br />
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Numero</label>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <input type="number" name="Numero" class="form-control" autofocus="true"
                                        value="{{ $solicitudes->Numero }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Fecha</label>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <input type="date" name="Fecha" class="form-control" autofocus="true"
                                        value="{{ $solicitudes->Fecha }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tipo de credito</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select name="Tipo" class="form-control">
                                        @foreach ($tipo as $obj)
                                            @if ($obj->Id == $solicitudes->Tipo)
                                                <Option value="{{ $obj->Id }}" selected>
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @else
                                                <Option value="{{ $obj->Id }}">
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            {{-- ESTA ES EL CODIGO PARA QUE APAREZCA EL DATO RELACIONADO QUE LE CORRESPONDE AL ID QUE SE VA A MODIFICAR  --}}
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Solicitante</label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    {{-- ANALIZAR LENTAMENTE ESTE CODIGO DE SELECCION --}}
                                    <select name="Solicitante" class="form-control select2" style="width: 100%">
                                        @foreach ($personas as $obj)
                                            @if ($obj->Id == $solicitudes->Solicitante)
                                                <Option value="{{ $obj->Id }}" selected>
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @else
                                                <Option value="{{ $obj->Id }}">
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Cantidad</label>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <input type="text" name="Cantidad" class="form-control" autofocus="true"
                                        value="{{ $solicitudes->Cantidad }}">
                                </div>
                            </div> --}}

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Fiador</label>
                                <div class="col-md-9 col-sm-12 col-xs-12">
                                    {{-- NO OLVIDAR ESTE NAME HACE REFERENCIA AL NOMBRE DEL CAMPO DE LA TABLA QUE SE ESTA USANDO COMO PRINCIPAL     --}}
                                    <select name="Fiador" id="Fiador" class="form-control select2" style="width: 100%">
                                        <option value="">Seleccione</option>
                                        @foreach ($fiadores as $obj)
                                            @if ($obj->Id == $solicitudes->Fiador)
                                                <Option value="{{ $obj->Id }}" selected>
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @else
                                                <Option value="{{ $obj->Id }}">
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                            </div>






                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Tasa%</label>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <input type="number" name="Tasa" class="form-control" autofocus="true"
                                        value="{{ $solicitudes->Tasa }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Cantidad</label>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <input type="number" name="Monto" class="form-control" autofocus="true"
                                        value="{{ $solicitudes->Monto }}">
                                </div>
                            </div>





                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Meses</label>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <input type="number" name="Meses" class="form-control" autofocus="true"
                                        value="{{ $solicitudes->Meses }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Estado</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select name="Estado" class="form-control">
                                        @foreach ($estados as $obj)
                                            @if ($obj->Id == $solicitudes->Estado)
                                                <Option value="{{ $obj->Id }}" selected>
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @else
                                                <Option value="{{ $obj->Id }}">
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>



                        </div>


                    </div>
                    <div class="form-group" align="center">
                        <button class="btn btn-success" type="submit">Modificar</button>
                        <a href="{{ url('catalogo/solicitudes') }}"><button class="btn btn-primary"
                                type="button">Cancelar</button></a>
                    </div>
                </form>


            </div>
        </div>
    </div>

@endsection
