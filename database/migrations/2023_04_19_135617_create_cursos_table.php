<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao');
            $table->timestamps();
        });


        Schema::create('curso_sugerido', function (Blueprint $table){
            $table->foreignId('aluno_id')
                    ->constrained('alunos')
                    ->onDelete('cascade');
            $table->foreignId('curso_id')
                    ->constrained('cursos')
                    ->onDelete('cascade');
            $table->date('desaparecer')->default(null)->nullable();
        });


        Schema::create('curso_professor', function (Blueprint $table){
            $table->foreignId('professor_id')
                    ->constrained('professores')
                    ->onDelete('cascade');
            $table->foreignId('curso_id')
                    ->constrained('cursos')
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
        Schema::dropIfExists('curso_professors');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
