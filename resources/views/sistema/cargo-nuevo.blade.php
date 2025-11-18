@extends('plantilla')
@section('titulo', "$titulo")
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/cargos">Cargos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $titulo }}</li>
</ol>
@endsection
@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $titulo }}</h5>
                        <a href="/admin/cargos" class="btn btn-outline-secondary btn-sm">Volver al listado</a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="frm_cargo" method="POST" novalidate>
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ isset($cargo->id_cargo_pk) ? $cargo->id_cargo_pk : 0 }}">

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="txtCargo" class="font-weight-bold">Nombre del Cargo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="txtCargo" name="txtCargo"
                                       value="{{ old('txtCargo', isset($cargo->Cargo) ? $cargo->Cargo : '') }}"
                                       placeholder="Nombre del cargo" maxlength="45" required>
                                <small class="form-text text-muted">Máximo 45 caracteres</small>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="lstEstado" class="font-weight-bold">Estado</label>
                                <select class="form-control form-control-lg" id="lstEstado" name="lstEstado">
                                    <option value="ACTIVO" {{ old('lstEstado', isset($cargo->estado) ? $cargo->estado : 'ACTIVO') == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                                    <option value="INACTIVO" {{ old('lstEstado', isset($cargo->estado) ? $cargo->estado : '') == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lstCategoria" class="font-weight-bold">Categoría Laboral</label>
                            <select class="form-control form-control-lg" id="lstCategoria" name="lstCategoria">
                                <option value="">-- Seleccionar --</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->idcategoria_laboral }}"
                                        {{ old('lstCategoria', isset($cargo->id_categoriaslaborales_FK) ? $cargo->id_categoriaslaborales_FK : '') == $cat->idcategoria_laboral ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="/admin/cargos" class="btn btn-outline-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary btn-lg">Guardar cargo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function(){
        const form = document.getElementById('frm_cargo');
        form.addEventListener('submit', function(e){
            const cargo = document.getElementById('txtCargo').value.trim();
            if(!cargo){
                e.preventDefault();
                alert('El campo Nombre del Cargo es obligatorio.');
                document.getElementById('txtCargo').focus();
                return false;
            }

            const id = document.getElementById('id').value;
            const action = (id && id !== '0') ? '/admin/cargo/' + id : '/admin/cargo/nuevo';
            form.action = action;
        });
    })();
</script>
@endsection
