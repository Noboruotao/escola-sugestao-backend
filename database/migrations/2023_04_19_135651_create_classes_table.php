<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')
                ->constrained('professors');
            $table->foreignId('disciplina_id')
                ->constrained('disciplinas');
            $table->boolean('ativo')
                ->default(true);
            $table->timestamps();
        });


        Schema::create('aluno_classe', function (Blueprint $table) {
            $table->foreignId('aluno_id')
                ->constrained('alunos')
                ->onDelete('cascade');
            $table->foreignId('classe_id')
                ->constrained('classes')
                ->onDelete('cascade');
            $table->integer('presença')
                ->default(0);
            $table->integer('faltas')
                ->default(0);
        });


        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')
                ->constrained('classes')
                ->onDelete('cascade');
            $table->string('dia_semana');
            $table->string('horario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
        Schema::dropIfExists('aluno_classe');
        Schema::dropIfExists('aulas');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
