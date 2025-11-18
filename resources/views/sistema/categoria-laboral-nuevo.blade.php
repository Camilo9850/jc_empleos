@extends('plantilla')

@section('contenido')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($menu->idmenu) && $menu->idmenu > 0 ? $menu->idmenu : 0; ?>';
    <?php $globalId = isset($menu->idmenu) ? $menu->idmenu : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/categorias-laborales">Categorías Laborales</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/categorias-laborales/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
    function fsalir() {
        location.href = "/admin/categorias-laborales";
    }
</script>
@endsection





<form method="POST" id="frm_categoria">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($categoria->idcategoria_laboral) ? $categoria->idcategoria_laboral : 0 }}">

    <div class="form-group">
        <label for="txtNombre">Nombre de la Categoría:</label>
        <input type="text" class="form-control" id="txtNombre" name="txtNombre"
            value="{{ isset($categoria->nombre) ? $categoria->nombre : '' }}" required>
    </div>

    <div class="form-group">
        <label for="txtDescripcion">Descripción:</label>
        <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"
            rows="4">{{ isset($categoria->descripcion) ? $categoria->descripcion : '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="lstEstado">Estado:</label>
        <select class="form-control" id="lstEstado" name="lstEstado">
            <option value="ACTIVO" {{ isset($categoria->estado) && $categoria->estado == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
            <option value="INACTIVO" {{ isset($categoria->estado) && $categoria->estado == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
        </select>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar
        </button>
        <a href="/admin/categorias-laborales" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</form>





<script>
    $(document).ready(function() {
        $('#frm_categoria').on('submit', function(e) {
            e.preventDefault();
            let id = $('#id').val();
            let url = id && id != "0" ? '/admin/categoria-laboral/' + id : '/admin/categoria-laboral/nuevo';

            this.action = url;
            this.submit();
        });
    });
</script>
@endsection