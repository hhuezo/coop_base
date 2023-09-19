@extends ('welcome')

@section('contenido')

    <div class="x_panel">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Nuevo Socio<small></small></h2>
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
                    <form action="{{ url('persona') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="text" name="Nombre"  class="form-control" autofocus="true"
                                    value="{{ old('Nombre') }}" required="true"
                                    onblur="this.value = this.value.toUpperCase()">
                            </div>
                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">DUI</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="text" name="Dui" data-inputmask="'mask': ['99999999-9']"
                                    value="{{ old('Dui') }}" class="form-control" autofocus="true" required="true"
                                    onblur="this.value = this.value.toUpperCase()">
                            </div>
                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nit</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="text" name="Nit" value="{{ old('Nit') }}" class="form-control">
                            </div>
                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Telefono</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="text" name="Telefono" value="{{ old('Telefono') }}"  data-inputmask="'mask': ['9999-9999']" class="form-control">
                            </div>
                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Correo</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="text" name="Correo" value="{{ old('Correo') }}" class="form-control">
                            </div>
                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>


                        {{-- AQUI SE AGREGA EL CODIGO PARA PRESENTAR EL NOMBRE DEL BANCO, CAMPO RELACIONADO ENTRE PERSONA-BANCO --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Banco</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="Banco" class="form-control">
                                    @foreach ($bancos as $obj)
                                        <Option value="{{ $obj->Id }}" {{ old('Banco') == $obj->Id ? 'selected' : '' }}>
                                            {{ $obj->Nombre }}

                                        </Option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cuenta</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{-- name es el nombre relacionado al nombre del campo --}}
                                <input type="text" name="NumeroCuenta" class="form-control" >
                            </div>
                            {{-- ESTO ES POR ESTETICA, SE FRAGMENTAN EL ESPACIO DE 12 EN 3,6,3 --}}
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Socio</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" name="Socio">
                            </div>
                            <label class="col-sm-3 control-label">&nbsp;</label>
                        </div>


                        <div class="form-group" align="center">
                            <button class="btn btn-success" type="submit">Guardar</button>
                            <a href="{{ url('persona') }}"><button class="btn btn-primary"
                                    type="button">Cancelar</button></a>
                        </div>

                    </form>
                </div>



            </div>

        </div>
    </div>
    </div>
@endsection
