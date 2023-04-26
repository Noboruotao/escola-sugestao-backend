<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtividadeExtracurricularesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_de_atividade_extracurricular', function (Blueprint $table){
            $table->id();
            $table->string('nome');
        });


        Schema::create('atividade_extracurriculares', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('tipo_id')
                    ->constrained('tipos_de_atividade_extracurricular');
            $table->date('ativo')->default(NULL)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });




        Schema::create('atividade_extracurricular_sugeridas', function (Blueprint $table){
            $table->foreignId('aluno_id')
                ->constrained('alunos')
                ->onDelete('cascade')
                ->name('ativ_extra_sugeridas_aluno_id_foreign');
            $table->foreignId('atividade_extracurricular_id')
                ->constrained('atividade_extracurriculares')
                ->onDelete('cascade')
                ->name('ativ_extra_sugeridas_atividade_extracurricular_id_foreign');
            $table->integer('vezes_mostradas');
            $table->date('aparecer')->default(NULL);
        });


        Schema::create('aluno_atividade_extracurriculares', function (Blueprint $table){
            $table->foreignId('aluno_id')
                    ->constrained('alunos')
                    ->primary()
                    ->onDelete('cascade');
            $table->foreignId('atividade_extracurricular_id')
                    ->constrained('atividade_extracurriculares')
                    ->primary()
                    ->onDelete('cascade')
                    ->name('aluno_ativ_extra_atividade_extracurricular_id_foreign');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atividade_extracurriculares');
        Schema::dropIfExists('tipos_de_atividade_extracurricular');
        Schema::dropIfExists('atividades_extracurricular_sugeridas');
        Schema::dropIfExists('aluno_atividade_extracurricular');
    }
}
