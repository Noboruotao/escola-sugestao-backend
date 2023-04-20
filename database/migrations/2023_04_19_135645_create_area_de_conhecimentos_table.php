<?php

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaDeConhecimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas_de_conhecimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });


        Schema::create('aluno_areas_de_conhecimentos', function (Blueprint $table){
            $table->foreignId('aluno_id')
                    ->constrained('alunos')
                    ->onDelete('cascade')
                    ->primary();
            $table->foreignId('area_de_conhecimento_id')
                    ->constrained('areas_de_conhecimentos')
                    ->primary()
                    ->onDelete('cascade');
            $table->float('valor_calculado_por_notas')
                    ->default(NULL)
                    ->nullable();
            $table->float('valor_calculado_pelo_emprestimo_de_acervo')
                    ->default(NULL)
                    ->nullable();
            $table->float('valor_respondido_pelo_aluno')
                    ->default(NULL)
                    ->nullable();
        });


        Schema::create('parametros_para_sugerir_curso', function (Blueprint $table){
            $table->foreignId('curso_id')
                    ->constrained('cursos')
                    ->primary()
                    ->onDelete('cascade');
            $table->foreignId('area_de_conhecimento_id')
                    ->constrained('areas_de_conhecimentos')
                    ->onDelete('cascade')
                    ->name('parametro_sugerir_curso_areas_conhecimento_id_foreign');
            $table->float('valor');
        });


        Schema::create('parametro_para_sugerir_atividade_extracurricular', function (Blueprint $table){
                $table->foreignId('atividade_extracurricular_id')
                        ->constrained('atividades_extracurriculares')
                        ->primary()
                        ->onDelete('cascade')
                        ->name('parametro_sugerir_ativ_extra_ativi_extra_id_foreign');
                $table->foreignId('areas_de_conhecimento_id')
                        ->constrained('areas_de_conhecimentos')
                        ->primary()
                        ->onDelete('cascade')
                        ->name('parametro_sugerir_ativ_extra_areas_conhecimentos_id_foreign');
                $table->float('valor');
        });


        Schema::create('areas_de_conhecimentos_atividades_extracurriculares', function (Blueprint $table){
            $table->foreignId('area_de_conhecimento_id')
                    ->constrained('areas_de_conhecimentos')
                    ->primary()
                    ->onDelete('cascade')
                    ->name('areas_conhecimento_ativ_extra_areas_conhecimento_id_foreign');
            $table->foreignId('atividade_extracurricular_id')
                    ->constrained('atividades_extracurricularres')
                    ->primary()
                    ->onDelete()
                    ->name('areas_conhecimento_ativ_extra_ativ_extra_id_foreign');
        });


        Schema::create('areas_de_conhecimento_disciplinas', function (Blueprint $table){
            $table->foreignId('area_de_conhecimento')
                    ->constrained('areas_de_conhecimentos')
                    ->primary()
                    ->onDelete('cascade');
            $table->foreignId('disciplina_id')
                    ->constrained('disciplinas')
                    ->primary()
                    ->onDelete('cascade');
        });


        Schema::create('acervos_areas_de_conhecimentos', function (Blueprint $table){
            $table->foreignId('acervo_id')
                    ->constrained('acervos')
                    ->primary()
                    ->onDelete('cascade');
            $table->foreignId('area_de_conhecimento')
                    ->constrained('areas_de_conhecimentos')
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
        Schema::dropIfExists('areas_de_conhecimentos');
        Schema::dropIfExists('aluno_areas_de_conhecimentos');
        Schema::dropIfExists('parametros_para_sugerir_curso');
        Schema::dropIfExists('parametro_para_sugerir_atividade_extracurricular');
        Schema::dropIfExists('areas_de_conhecimentos_atividades_extracurriculares');
        Schema::dropIfExists('areas_de_conhecimento_disciplinas');
        Schema::dropIfExists('acervos_areas_de_conhecimentos');

    }
}
