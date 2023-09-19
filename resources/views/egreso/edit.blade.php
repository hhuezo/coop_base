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

                <form method="POST" action="{{ route('egreso.update', $egresos->Id) }}">
                    @method('PUT')
                    @csrf

                    <div class="x_content">
                        <br />
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Numero</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="number" name="Numero" class="form-control" autofocus="true"
                                        value="{{ $egresos->Numero }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Fecha</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="date" name="Fecha" class="form-control" autofocus="true"
                                        value="{{ $egresos->Fecha }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Descripcion</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="text" name="Descripcion" class="form-control" autofocus="true"
                                        value="{{ $egresos->Descripcion }}">
                                </div>
                            </div>
                            {{-- ESTA ES EL CODIGO PARA QUE APAREZCA EL DATO RELACIONADO QUE LE CORRESPONDE AL ID QUE SE VA A MODIFICAR  --}}
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tipo</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{-- ANALIZAR LENTAMENTE ESTE CODIGO DE SELECCION --}}
                                    <select name="Tipo" class="form-control">
                                        @foreach ($tipo as $obj)
                                            @if ($obj->Id == $egresos->Tipo)
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

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Monto</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="number" name="Cantidad" class="form-control" autofocus="true"
                                        value="{{ $egresos->Cantidad }}">
                                </div>
                            </div>

                            {{-- ESTA ES EL CODIGO PARA QUE APAREZCA EL DATO RELACIONADO QUE LE CORRESPONDE AL ID QUE SE VA A MODIFICAR  --}}
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Rubro</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{-- ANALIZAR LENTAMENTE ESTE CODIGO DE SELECCION --}}
                                    <select name="Rubro" class="form-control">
                                        @foreach ($rubros as $obj)
                                            @if ($obj->Id == $egresos->Rubro)
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
                                <label class="col-sm-3 control-label">Usuario</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{-- ANALIZAR LENTAMENTE ESTE CODIGO DE SELECCION --}}
                                    <select name="Usuario" class="form-control">
                                        @foreach ($usuarios as $obj)
                                            @if ($obj->Id == $egresos->Usuario)
                                                <Option value="{{ $obj->Id }}" selected>
                                                    {{ $obj->Usuario }}
                                                </Option>
                                            @else
                                                <Option value="{{ $obj->Id }}">
                                                    {{ $obj->Usuario }}
                                                </Option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Fecha de Ingreso</label>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="datetime-local" name="FechaIngreso" class="form-control" autofocus="true"
                                        value="{{ $egresos->FechaIngreso }}">
                                </div>
                                



                                <div class="form-group" align="center">
                                    <button class="btn btn-success" type="submit">Modificar</button>
                                    <a href="{{ url('egreso') }}"><button class="btn btn-primary"
                                            type="button">Cancelar</button></a>
                                </div>
                            </div>
                </form>
            </div>
        </div>
    </div>

@endsection
