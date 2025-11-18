@extends('plantilla')

@section('contenido')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5>{{ $titulo }}</h5>
            </div>
            <div class="card-body">
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
            </div>
        </div>
    </div>
</div>

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
