<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Listado de aportaciones <small></small>

                    </h2>
                    <ul class="nav navbar-right panel_toolbox">

                        <select class="form-control" wire:model="axo">
                            @foreach ($axos as $obj)
                                <option value="{{ $obj }}">{{ $obj }}</option>
                            @endforeach
                        </select>
                        <!-- <a href="aportacion_nuevo.php"><button class="btn btn-warning">Nueva aportacion</button></a> -->
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="contenido">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <center>
                                        <i class="fa fa-plus"></i>
                                    </center>
                                </th>
                                <th>
                                    <center>Socio</center>
                                </th>
                                @for ($i = 1; $i <= 12; $i++)
                                    <th>
                                        <center>{{ substr($meses[$i], 0, 3) }}</center>
                                    </th>
                                @endfor



                            </tr>
                        </thead>

                        @foreach ($registros as $registro)
                            <tr>
                                <td>
                                    <button class="btn btn-success" data-target="#modal-aportacion" data-toggle="modal"
                                        wire:click="modal_aportacion({{ $registro->Id }})"><i
                                            class="fa fa-plus"></i></button>

                                </td>
                                <td>{{ $registro->Nombre }}</td>

                                <td align="right">${{ $registro->enero }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/1/{{ $axo }}/1">
                                        <button class="btn btn-primary" {{ $registro->enero == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/1/{{ $axo }}/2">
                                        <button class="btn btn-info" {{ $registro->enero == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->febrero }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/2/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->febrero == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/2/{{ $axo }}/2">
                                        <button class="btn btn-info" {{ $registro->febrero == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->marzo }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/3/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->marzo == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/3/{{ $axo }}/2">
                                        <button class="btn btn-info" {{ $registro->marzo == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->abril }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/4/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->abril == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/4/{{ $axo }}/2">
                                        <button class="btn btn-info" {{ $registro->abril == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->mayo }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/5/{{ $axo }}/1">
                                        <button class="btn btn-primary" {{ $registro->mayo == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/5/{{ $axo }}/2">
                                        <button class="btn btn-info" {{ $registro->mayo == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->junio }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/6/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->junio == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/6/{{ $axo }}/2">
                                        <button class="btn btn-info" {{ $registro->junio == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->julio }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/7/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->julio == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/7/{{ $axo }}/2">
                                        <button class="btn btn-info" {{ $registro->julio == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->agosto }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/8/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->agosto == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/8/{{ $axo }}/2">
                                        <button class="btn btn-info" {{ $registro->agosto == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->septiembre }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/9/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->septiembre == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/9/{{ $axo }}/2">
                                        <button class="btn btn-info"
                                            {{ $registro->septiembre == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->octubre }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/10/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->octubre == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/10/{{ $axo }}/2">
                                        <button class="btn btn-info" {{ $registro->octubre == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->noviembre }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/11/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->noviembre == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/11/{{ $axo }}/2">
                                        <button class="btn btn-info"
                                            {{ $registro->noviembre == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                                <td align="right">${{ $registro->diciembre }}<br>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/12/{{ $axo }}/1">
                                        <button class="btn btn-primary"
                                            {{ $registro->diciembre == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-print"></i></button>
                                    </a>
                                    <a
                                        href="{{ url('control/aportacion/reporte_aportacion') }}/{{ $registro->Id }}/12/{{ $axo }}/2">
                                        <button class="btn btn-info"
                                            {{ $registro->diciembre == 0 ? 'disabled' : '' }}><i
                                                class="fa fa-send"></i></button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal-aportacion" tabindex="-1" wire:ignore.self role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" data-tipo="1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="save">

                    <div class="modal-header">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva apostación</h5>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <div class="col-sm-12">Año
                                <input type="text" wire:model="axo" readonly class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">Mes
                                <select wire:model="mes" class="form-control" required style="width: 100%">
                                    <option value="">Seleccione</option>
                                    @for ($i = 1; $i < 13; $i++)
                                        <Option value="{{ $i }}">
                                            {{ $meses[$i] }}
                                        </Option>
                                    @endfor
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-sm-12">Fecha
                                <input type="date" wire:model="fecha" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-12">Socio
                                <input type='hidden' wire:model="socio" class="form-control" />
                                <input type='text' wire:model="socio_nombre" readonly class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">Aportanción
                                <input type='number' step="0.01" wire:model="cantidad_aportacion" required
                                    min="1.00" class="form-control" />
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
    <script>
        document.addEventListener('close-modal', function() {
            $("#modal-aportacion").modal("hide");
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Tu acción se ha completado con éxito.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
</div>
