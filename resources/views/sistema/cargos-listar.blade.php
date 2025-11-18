@extends('plantilla')
@section('titulo', "Listado de Cargos")
@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item active">Cargos</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/cargo/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/cargos");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<table id="grilla" class="display">
    <thead>
        <tr>
            <th>Cargo</th>
            <th>Categoría</th>
            <th>Estado</th>
        </tr>
    </thead>
</table>
<script>
    var dataTable = $('#grilla').DataTable({
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "bInfo": true,
        "bSearchable": true,
        "pageLength": 25,
        "order": [[0, "asc"]],
        "ajax": "{{ route('cargo.cargarGrilla') }}"
    });
</script>
@endsection
