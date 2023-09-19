@extends ('welcome')
@section('contenido')

    <div class="x_panel">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Modificar persona <small></small></h2>
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

                <form method="POST" action="{{ route('persona.update', $persona->Id) }}">
                    @method('PUT')
                    @csrf

                    <div class="x_content">
                        <br />
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Nombre</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="text" name="Nombre" class="form-control" autofocus="true"
                                        onblur="this.value = this.value.toUpperCase()" value="{{ $persona->Nombre }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Dui</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="text" name="Dui" class="form-control" autofocus="true"
                                        onblur="this.value = this.value.toUpperCase()" value="{{ $persona->Dui }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Nit</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="text" name="Nit" class="form-control" autofocus="true"
                                        onblur="this.value = this.value.toUpperCase()" value="{{ $persona->Nit }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Telefono</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="text" name="Telefono" class="form-control" autofocus="true"
                                        onblur="this.value = this.value.toUpperCase()" value="{{ $persona->Telefono }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Correo</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="email" name="Correo" class="form-control" autofocus="true"
                                        value="{{ $persona->Correo }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Socio</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="checkbox" name="Socio" {{$persona->Socio == 1 ? 'checked':''}}>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Banco</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{-- ANALIZAR LENTAMENTE ESTE CODIGO DE SELECCION --}}
                                    <select name="Banco" class="form-control">
                                        @foreach ($bancos as $obj)
                                            @if ($obj->Id == $persona->Banco)
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
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">NumeroCuenta</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="text" name="NumeroCuenta" class="form-control" autofocus="true"
                                        onblur="this.value = this.value.toUpperCase()"
                                        value="{{ $persona->NumeroCuenta }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Activo</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <input type="checkbox" name="Activo" {{$persona->Activo == 1 ? 'checked':''}}>
                                </div>
                            </div>



                            <div class="form-group" align="center">
                                <button class="btn btn-success" type="submit">Modificar</button>
                                <a href="{{ url('persona') }}"><button class="btn btn-primary"
                                        type="button">Cancelar</button></a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
