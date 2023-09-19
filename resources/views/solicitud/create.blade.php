@extends ('welcome')
@section('contenido')

    <div class="x_panel">

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Nueva solicitud<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox"></ul>
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
                    <form action="{{ url('solicitud') }}" method="POST">
                        @csrf



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

                                <label class="col-sm-3 control-label">Solicitante</label>
                                <div class="col-md-9 col-sm-12 col-xs-12">
                                    {{-- NO OLVIDAR ESTE NAME HACE REFERENCIA AL NOMBRE DEL CAMPO DE LA TABLA QUE SE ESTA USANDO COMO PRINCIPAL     --}}

                                    <select name="Solicitante" id="Solicitante" class="form-control select2"
                                        style="width: 100%" required>
                                        @foreach ($personas as $obj)
                                            <Option value="{{ $obj->Id }}">
                                                {{ $obj->Nombre }}
                                            </Option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>




                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Fiador</label>
                                <div class="col-md-9 col-sm-12 col-xs-12">
                                    {{-- NO OLVIDAR ESTE NAME HACE REFERENCIA AL NOMBRE DEL CAMPO DE LA TABLA QUE SE ESTA USANDO COMO PRINCIPAL     --}}
                                    <select name="Fiador" id="Fiador" class="form-control select2" disabled
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
                                <label class="col-sm-3 control-label">Tasa %</label>
                                <div class="col-md-9 col-sm-12 col-xs-12">
                                    <input type="number" step="0.01" name="Tasa" class="form-control" value="4"
                                        readonly required="true">
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






                <div class="form-group" align="center">
                    <button class="btn btn-success" type="submit">Guardar</button>
                    <a href="{{ url('solicitud') }}"><button class="btn btn-primary" type="button">Cancelar</button></a>
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
    </script>



@endsection
