<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class Cargos extends Model
{
   
    protected $table = 'tbl_cargo';

    // Clave primaria personalizada
    protected $primaryKey = 'id_cargo_pk';
   
    public $timestamps = false;

    // Campos que se pueden asignar masivamente (ajusta los nombres según necesites)
    protected $fillable = [
        'Cargo',
        'id_categoriaslaborales_FK',
        'estado',
    ];

    // Relación: un cargo pertenece a una categoría laboral
    public function categoriaLaboral()
    {
        return $this->belongsTo(CategoriasLaborales::class, 'id_categoriaslaborales_FK', 'idcategoria_laboral');
    }

    // Conveniencia: cargar desde Request siguiendo la convención del repo
    public function cargarDesdeRequest($request)
    {
        $this->id_Cargo_PK = $request->input('id') != "0" ? $request->input('id') : $this->id_Cargo_PK;
        $this->Cargo = $request->input('txtCargo');
        $this->id_categoriaslaborales_FK = $request->input('lstCategoria') != "" ? $request->input('lstCategoria') : null;
        $this->estado = $request->input('lstEstado');
    }

    // insert / update si quieres seguir el estilo del proyecto (opcional)
    public function insertar()
    {
        $this->save();
        return $this->id_Cargo_PK;
    }

    public function guardar()
    {
        $this->save();
    }
}