@extends ('welcome')

@section('contenido')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Saldos <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="{{ url('reportes/saldos') }}" data-parsley-validate
                        class="form-horizontal form-label-left" target="_blank" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="date" name="Fecha" value="{{ date('Y-m-') }}01" required
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-group" align="center">
                            <button id="btn_aceptar" type="submit" class="btn btn-info ">Aceptar</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
