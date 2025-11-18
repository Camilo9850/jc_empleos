@extends('plantilla')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{ $titulo }}</h5>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="/admin/categoria-laboral/nuevo" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Nueva Categoría
                        </a>
                    </div>
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
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
            "columnDefs": [
                {
                    "targets": 3,
                    "data": null,
                    "render": function(data, type, row) {
                        return `
                            <a href="/admin/categoria-laboral/${row.idcategoria_laboral}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button class="btn btn-danger btn-sm" onclick="eliminarCategoria(${row.idcategoria_laboral})">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        `;
                    }
                }
            ],
            "columns": [
                { "data": "nombre" },
                { "data": "descripcion" },
                { "data": "estado" },
                { "data": null }
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
