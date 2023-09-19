@extends ('welcome')
@section('contenido')
    
    <div class="x_panel">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

                <div class="x_title">
                    <h2>Modificar el nombre del Banco <small></small></h2>
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

                <form method="POST" action="{{ route('banco.update', $banco->Id) }}">
                    @method('PUT')
                    @csrf

                    <div class="x_content">
                        <br />
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Nombre</label>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <input type="text" name="Nombre" class="form-control" autofocus="true" onblur="this.value = this.value.toUpperCase()"
                                        value="{{ $banco->Nombre }}">
                                </div>

                            </div>
                            <div class="form-group" align="center">
                                <button class="btn btn-success" type="submit">Modificar</button>
                                <a href="{{ url('banco') }}"><button class="btn btn-primary"
                                        type="button">Cancelar</button></a>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection