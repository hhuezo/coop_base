@extends ('welcome')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="x_panel">

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Nueva Solicitud<small></small></h2>

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

                <div class="x_content">
                    {{-- metodo post porque es para guardar los datos --}}
                    <form action="{{ url('control/solicitud') }}" method="POST">
                        @csrf

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {{-- PRIMEROS 3 DE 12 --}}
                                    <label class="col-sm-3 control-label">Numero</label>
                                    {{-- SIGUIENTES 9 PARA LLEGAR A 12 --}}
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <input type="number" name="Numero" class="form-control" readonly>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Fecha</label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <input type="date" name="Fecha" class="form-control" required="true"
                                            value="{{ date('Y-m-d') }}">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tipo de crédito</label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        {{-- NO OLVIDAR ESTE NAME HACE REFERENCIA AL NOMBRE DEL CAMPO DE LA TABLA QUE SE ESTA USANDO COMO PRINCIPAL     --}}
                                        <select name="TipoCredito" class="form-control" style="width: 100%">
                                            @foreach ($tipo as $obj)
                                                <Option value="{{ $obj->Id }}">
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>




                                <div class="form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12 control-label">Solicitante</label>
                                    <div class="input-group col-md-9 col-sm-12 col-xs-12">
                                        <select name="Solicitante" id="Solicitante" class="form-control select2"
                                            style="width: 100%" required>
                                            @foreach ($personas as $obj)
                                                <Option value="{{ $obj->Id }}">
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" data-target="#modal-persona"
                                                data-toggle="modal">Nuevo</button>
                                        </span>
                                    </div>

                                </div>

                            </div>




                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Fiador</label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        {{-- NO OLVIDAR ESTE NAME HACE REFERENCIA AL NOMBRE DEL CAMPO DE LA TABLA QUE SE ESTA USANDO COMO PRINCIPAL     --}}
                                        <select name="Fiador" id="Fiador" class="form-control select2"
                                            style="width: 100%">
                                            <option value="">Seleccione</option>
                                            @foreach ($fiadores as $obj)
                                                <Option value="{{ $obj->Id }}">
                                                    {{ $obj->Nombre }}
                                                </Option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tasa</label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <input type="number" step="0.01" name="Tasa" class="form-control"
                                            value="4" readonly required="true">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Cantidad</label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <input type="number" step="0.01" name="Cantidad" class="form-control"
                                            autofocus="true" required="true" value="{{ old('Cantidad') }}">
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meses</label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <input type="number" name="Meses" class="form-control" autofocus="true"
                                            required="true" value="{{ old('Meses') }}">
                                    </div>

                                </div>

                            </div>

                        </div>

                </div>

                <div class="form-group" align="center">
                    <button class="btn btn-success" type="submit">Guardar</button>
                    <a href="{{ url('control/solicitud') }}"><button class="btn btn-primary"
                            type="button">Cancelar</button></a>
                </div>

                </form>
            </div>
        </div>
    </div>




    <div class="modal fade" id="modal-persona" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-tipo="1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('control/solicitud/recibo') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva persona</h5>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <div class="col-sm-12">Banco
                                <select id="Banco" class="form-control" style="width: 100%">
                                    <option value="">Seleccione</option>
                                    @foreach ($bancos as $obj)
                                        <Option value="{{ $obj->Id }}" {{ $obj->Id == 6 ? 'selected' : '' }}>
                                            {{ $obj->Nombre }}
                                        </Option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">Número cuenta
                                <input type="text" id="NumeroCuenta" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">Nombre
                                <input type="text" name="Nombre" id="Nombre" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-12">DUI
                                <input type='text' id="Dui" class="form-control"
                                    data-inputmask="'mask' : '99999999-9'" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">NIT
                                <input type='text' id="Nit" class="form-control"
                                    data-inputmask="'mask' : '9999-999999-999-9'" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">Telefono
                                <input type='text' id="Telefono" data-inputmask="'mask' : '9999-9999'"
                                    class="form-control" />
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-12">Correo
                                <input type='text' id="Correo" class="form-control" />
                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                        <button type="button" onclick="guardar_persona()" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#Solicitante").change(function() {
                var Solicitante = $(this).val();
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                $.get("{{ url('control/solicitud/get_fiador') }}" + '/' + Solicitante, function(data) {
                    console.log(data);
                    if (data == 0) {
                        //console.log("no socio");
                        $("#Fiador").prop('disabled', false);
                        $("#Fiador").attr("required", true);
                    } else {
                        $("#Fiador").prop('disabled', true);
                        $("#Fiador").attr("required", false);

                    }
                });

            });


        });

        function guardar_persona() {
            if (document.getElementById('Nombre').value.trim() == '') {
                alert('El nombre es requerido');
                return false;
            }

            if (document.getElementById('Dui').value.trim() == '') {
                alert('El DUI es requerido');
                return false;
            }

            if (document.getElementById('NumeroCuenta').value.trim() == '') {
                alert('El numero de cuenta es requerido');
                return false;
            }
            var parametros = {
                _token: "{{ csrf_token() }}",
                Nombre: document.getElementById('Nombre').value,
                Dui: document.getElementById('Dui').value,
                Nit: document.getElementById('Nit').value,
                Telefono: document.getElementById('Telefono').value,
                Correo: document.getElementById('Correo').value,
                Banco: document.getElementById('Banco').value,
                NumeroCuenta: document.getElementById('NumeroCuenta').value,
            };
            $.ajax({
                type: "post",
                url: "{{ url('control/solicitud/create_persona') }}",
                data: parametros,
                success: function(data) {
                    console.log(data);

                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].Id + '"  selected >' + data[i].Nombre +
                        '</option>';
                    $("#Solicitante").html(_select);
                    $('#modal-persona').modal('hide');
                }

            });
        }
    </script>
@endsection
