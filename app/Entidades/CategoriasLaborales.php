<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash; // Necesario para la seguridad de la clave

class CategoriasLaborales extends Model
{
    protected $table = 'categorias_laborales';
    
    // Especificar el nombre de la clave primaria
    protected $primaryKey = 'idcategoria_laboral';

    protected $guarded = [];

 


}