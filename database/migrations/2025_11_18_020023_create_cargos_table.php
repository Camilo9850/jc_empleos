<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cargo', function (Blueprint $table) {
            $table->increments('id_cargo_pk');
            $table->string('Cargo', 45);
            $table->unsignedInteger('id_categoriaslaborales_FK')->nullable();
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');

            $table->index('id_categoriaslaborales_FK', 'fk_categoria_idx');
            $table->foreign('id_categoriaslaborales_FK', 'tbl_cargo_categoria_fk')
                ->references('idcategoria_laboral')->on('categorias_laborales')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_cargo');
    }
}
