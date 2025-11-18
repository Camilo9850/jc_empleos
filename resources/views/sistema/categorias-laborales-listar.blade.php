@extends('plantilla')

@section('contenido')
<div class="container">
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categorías Laborales</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Gestión de Categorías Laborales</h5>
                <a href="/admin/categoria-laboral/nuevo" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nueva Categoría
                </a>
            </div>
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

            <table class="table table-bordered table-striped" id="tblCategorias" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th style="width: 150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let tblCategorias = $('#tblCategorias').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            "pageLength": 10,
            "ajax": {
                "url": "{{ route('categoria.cargarGrilla') }}",
                "type": "GET"
            },
            "columns": [
                { "data": "nombre" },
                { "data": "descripcion" },
                { "data": "estado" },
                {
                    "data": "idcategoria_laboral",
                    "orderable": false,
                    "searchable": false,
                    "render": function(data, type, row) {
                        return `
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="/admin/categoria-laboral/${data}" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <button class="btn btn-danger" onclick="eliminarCategoria(${data})" title="Eliminar">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </div>
                        `;
                    }
                }
            ]
        });

        window.eliminarCategoria = function(id) {
            if (confirm('¿Está seguro de que desea eliminar esta categoría?')) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/categoria-laboral/eliminar',
                    data: { id: id },
                    success: function(response) {
                        if (response.success) {
                            alert(response.success);
                            tblCategorias.ajax.reload();
                        }
                    },
                    error: function(err) {
                        if (err.responseJSON && err.responseJSON.error) {
                            alert('Error: ' + err.responseJSON.error);
                        } else {
                            alert('Error al eliminar la categoría');
                        }
                    }
                });
            }
        };
    });
</script>
@endsection
