<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class CategoriasLaborales extends Model
{
    protected $table = 'categorias_laborales';
    
    protected $primaryKey = 'idcategoria_laboral';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    public function cargos()
    {
        return $this->hasMany(\App\Entidades\Cargos::class, 'id_categoriaslaborales_FK', 'idcategoria_laboral');
    }
}