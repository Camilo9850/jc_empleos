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
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Gestión de Cargos</h5>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <table id="grilla" class="table table-bordered table-striped display">
            <thead>
                <tr>
                    <th>Cargo</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th style="width: 150px;">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    var dataTable = $('#grilla').DataTable({
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "bInfo": true,
        "bSearchable": true,
        "pageLength": 25,
        "order": [[0, "asc"]],
        "ajax": "{{ Route::has('cargo.cargarGrilla') ? route('cargo.cargarGrilla') : url('/admin/cargo/cargarGrilla') }}",
        "columns": [
            { "data": "cargo" },
            { "data": "categoria" },
            { "data": "estado" },
            {
                "data": "id",
                "orderable": false,
                "searchable": false,
                "render": function(data, type, row) {
                    return `
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="/admin/cargo/${data}" class="btn btn-primary" title="Editar">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn btn-danger" onclick="eliminarCargo(${data})" title="Eliminar">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    function eliminarCargo(id) {
        if(confirm('¿Está seguro de que desea eliminar este cargo?')) {
            $.ajax({
                type: 'GET',
                url: '/admin/cargo/eliminar',
                data: { id: id },
                success: function(response) {
                    if(response.success) {
                        alert(response.success);
                        dataTable.ajax.reload();
                    } else if(response.error) {
                        alert('Error: ' + response.error);
                    }
                },
                error: function(err) {
                    const errMsg = err.responseJSON && err.responseJSON.error ? err.responseJSON.error : 'Error desconocido';
                    alert('Error al eliminar: ' + errMsg);
                }
            });
        }
    }
</script>
@endsection
