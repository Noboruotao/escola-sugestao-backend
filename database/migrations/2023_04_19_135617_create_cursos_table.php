<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao');
            $table->timestamps();
        });


        Schema::create('cursos_sugeridos', function (Blueprint $table){
            $table->foreignId('aluno_id')
                    ->constrained('alunos')
                    ->primary()
                    ->onDelete('cascade');
            $table->foreignId('curso_id')
                    ->constrained('cursos')
                    ->primary()
                    ->onDelete('cascade');
        });


        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
        Schema::dropIfExists('cursos_sugeridos');
    }
}
