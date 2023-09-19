@extends ('welcome')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="x_panel">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Solicitud<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <a href="{{ url('control/solicitud/reporte_solicitud') }}/{{ $solicitud->Id }}/1" target="_blank">
                            <button class="btn btn-warning"><i class="fa fa-print"></i></button>
                        </a>

                        <a href="{{ url('control/solicitud/reporte_solicitud') }}/{{ $solicitud->Id }}/2">
                            <button class="btn btn-info"><i class="fa fa-send"></i></button>
                        </a>
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



                <div class="x_content">
                    <br />
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">Numero</label>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="number" name="Numero" class="form-control" autofocus="true"
                                    value="{{ $solicitud->Numero }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">Fecha</label>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="date" name="Fecha" class="form-control" autofocus="true"
                                    value="{{ $solicitud->Fecha }}">
                            </div>
                        </div>


                        {{-- ESTA ES EL CODIGO PARA QUE APAREZCA EL DATO RELACIONADO QUE LE CORRESPONDE AL ID QUE SE VA A MODIFICAR  --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Solicitante</label>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                {{-- ANALIZAR LENTAMENTE ESTE CODIGO DE SELECCION --}}
                                <select name="Solicitante" class="form-control select2" style="width: 100%">
                                    @foreach ($personas as $obj)
                                        @if ($obj->Id == $solicitud->Solicitante)
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
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">Cantidad</label>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="text" name="Cantidad" class="form-control" autofocus="true"
                                    value="{{ $solicitud->Cantidad }}">
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">Tasa</label>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="number" name="Tasa" class="form-control" autofocus="true"
                                    value="{{ $solicitud->Tasa }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">Meses</label>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="number" name="Meses" class="form-control" autofocus="true"
                                    value="{{ $solicitud->Meses }}">
                            </div>
                        </div>

                    </div>




                </div>
                <div class="form-group" align="center">

                    <button type="button" {{ $solicitud->Estado == 2 ? '' : 'disabled' }} data-target="#modal-recibo"
                        data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus fa-lg"></i> Nuevo Recibo</button>


                    <a href="{{ url('control/solicitud') }}"><button class="btn btn-info"
                            type="button">Volver</button></a>
                </div>

                <div>

                    <div class="x_title">
                        <h2>Recibos<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Fecha</th>
                                {{-- <th>Solicitud</th>
                                <th>Numero</th> --}}
                                <th>Pago</th>
                                <th>Interes</th>
                                {{-- <th>Cantidad Actual</th> --}}
                                <th>Capital</th>
                                <th>Saldo pendiente</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($recibos as $obj)
                                <tr>
                                    <td align="center">{{ $obj->Numero }}</td>
                                    <td>{{ date('d/m/Y', strtotime($obj->Fecha)) }}</td>
                                    {{-- AQUI SE AGREGA EL NOMBRE DE LA FUNCION DE LA RELACION QUE ESTA EN EL MODELO SEGUIDO DEL NOMBRE EXACTO DEL CAMPO --}}
                                    {{-- <td>{{ $obj->ObjReciboSolicitud->Numero }}</td>
                                    <td>{{ $obj->Numero }}</td> --}}
                                    <td>${{ $obj->Pago }}</td>
                                    <td>{{ $obj->Interes }}</td>
                                    {{-- <td>${{ $obj->CantidadActual }}</td> --}}
                                    <td>$ {{ $obj->Capital }}</td>
                                    <td>$ {{ $obj->Total }}</td>
                                    <td>
                                        <a href="{{ url('control/solicitud/reporte_recibo') }}/{{ $obj->Id }}/1"
                                            target="_blank">
                                            <button class="btn btn-warning"><i class="fa fa-print"></i></button>
                                        </a>

                                        <a href="{{ url('control/solicitud/reporte_recibo') }}/{{ $obj->Id }}/2">
                                            <button class="btn btn-info"><i class="fa fa-send"></i></button>
                                        </a>
                                    </td>


                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>

            </div>
        </div>








        <div class="modal fade" id="modal-recibo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" data-tipo="1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ url('control/solicitud/recibo') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <h5 class="modal-title" id="exampleModalLabel">Nuevo recibo</h5>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="form-group">
                                <div class="col-sm-12">
                                    Fecha<input type="date" id="Fecha" name="Fecha"
                                        value="{{ date('Y-m-d') }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    Monto<input type="number" readonly name="Monto" id="Monto"
                                        value="{{ $capital }}" class="form-control">
                                    <input type="hidden" name="Solicitud" readonly id="Solicitud"
                                        value="{{ $solicitud->Id }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    Interes<input type="number" readonly name="Interes" id="Interes"
                                        value="{{ $interes }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    Total<input type="number" readonly id="Total" value="{{ $capital + $interes }}"
                                        class="form-control">

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    Pago<input type="number" name="Pago" id="Pago"
                                        max="{{ $capital + $interes }}" class="form-control" required step="0.01"
                                        min="0.01">

                                </div>
                            </div>



                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>



        <!-- jQuery -->
        <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>



        <script type="text/javascript">
            $(document).ready(function() {
                $("#Fecha").change(function() {

                    // var para la Departamento                            
                    var Fecha = $(this).val();
                    var Solicitud = document.getElementById('Solicitud').value;
                    $.get("{{ url('control/solicitud/calculo_recibo') }}" + '/' + Solicitud + '/' + Fecha,
                        function(data) {

                            console.log(data);
                            var capital = parseFloat(data.Capital);
                            var interes = parseFloat(data.Interes);
                            document.getElementById('Monto').value = capital.toFixed(2);
                            document.getElementById('Interes').value = interes.toFixed(2);
                            document.getElementById('Total').value = (interes + capital).toFixed(2);
                            $("#Pago").attr({
                                "max": (interes + capital).toFixed(2)
                            });
                        });

                });
            });
        </script>




    </div>

@endsection
