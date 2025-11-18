@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($cargo->id_cargo_pk) && $cargo->id_cargo_pk > 0 ? $cargo->id_cargo_pk : 0; ?>';
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/cargos">Cargos</a></li>
    <li class="breadcrumb-item active">{{ $titulo }}</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/cargo/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Volver" href="/admin/cargos" class="fa fa-arrow-left" aria-hidden="true"><span>Volver</span></a></li>
</ol>
@endsection
@section('contenido')
<div class="panel-body">
    <div id="msg"></div>
    <form id="form1" method="POST">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="id" name="id" class="form-control" value="{{isset($cargo->id_cargo_pk) ? $cargo->id_cargo_pk : 0}}" required>
            
            <div class="form-group col-lg-12">
                <label>Nombre del Cargo: *</label>
                <input type="text" id="txtCargo" name="txtCargo" class="form-control" value="{{ isset($cargo->Cargo) ? $cargo->Cargo : '' }}" required maxlength="45">
            </div>

            <div class="form-group col-lg-6">
                <label>Categoría Laboral:</label>
                <select id="lstCategoria" name="lstCategoria" class="form-control">
                    <option value=""></option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->idcategoria_laboral }}" 
                            @if(isset($cargo->id_categoriaslaborales_FK) && $cargo->id_categoriaslaborales_FK == $cat->idcategoria_laboral) selected @endif>
                            {{ isset($cat->nombre) ? $cat->nombre : (isset($cat->categoria_laboral) ? $cat->categoria_laboral : 'Sin nombre') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label>Estado: *</label>
                <select id="lstEstado" name="lstEstado" class="form-control" required>
                    <option value="ACTIVO" @if(isset($cargo->estado) && $cargo->estado == 'ACTIVO') selected @endif>Activo</option>
                    <option value="INACTIVO" @if(isset($cargo->estado) && $cargo->estado == 'INACTIVO') selected @endif>Inactivo</option>
                </select>
            </div>

            <div class="form-group col-lg-12">
                <button type="submit" class="btn btn-primary fa fa-save" onclick="guardar();"> Guardar</button>
                <a href="/admin/cargos" class="btn btn-secondary fa fa-arrow-left"> Volver</a>
            </div>
        </div>
    </form>
</div>

<script>
    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            form1.submit();
        } else {
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }
</script>
@endsection
