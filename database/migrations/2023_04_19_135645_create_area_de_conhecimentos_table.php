<?php

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAreaDeConhecimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('areas_de_conhecimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });


        Schema::create('aluno_areas_de_conhecimento', function (Blueprint $table){
            $table->foreignId('aluno_id')
                    ->constrained('alunos')
                    ->onDelete('cascade');
            $table->foreignId('areas_de_conhecimento_id')
                    ->constrained('areas_de_conhecimentos')
                    ->onDelete('cascade');
            $table->float('valor_calculado_por_notas')
                    ->default(NULL)
                    ->nullable();
            $table->float('valor_calculado_pelo_emprestimo_de_acervo')
                    ->default(NULL)
                    ->nullable();
            $table->float('valor_calculado_por_atividade_extracurricular')
                    ->default(NULL)
                    ->nullable();
            $table->float('valor_respondido_pelo_aluno')
                    ->default(NULL)
                    ->nullable();
        });


        Schema::create('parametros_para_sugerir_curso', function (Blueprint $table){
            $table->foreignId('curso_id')
                    ->constrained('cursos')
                    ->onDelete('cascade');
            $table->foreignId('areas_de_conhecimento_id')
                    ->constrained('areas_de_conhecimentos')
                    ->onDelete('cascade')
                    ->name('parametro_sugerir_curso_areas_conhecimentos_id_foreign');
            $table->float('valor');
        });


        Schema::create('parametro_para_sugerir_atividade_extracurricular', function (Blueprint $table){
                $table->foreignId('atividades_extracurriculares_id')
                        ->constrained('atividades_extracurriculares')
                        ->onDelete('cascade')
                        ->name('parametro_sugerir_ativ_extra_ativi_extra_id_foreign');
                $table->foreignId('areas_de_conhecimento_id')
                        ->constrained('areas_de_conhecimentos')
                        ->onDelete('cascade')
                        ->name('parametro_sugerir_ativ_extra_areas_conhecimentos_id_foreign');
                $table->float('valor');
        });


        Schema::create('areas_de_conhecimento_atividades_extracurricular', function (Blueprint $table){
            $table->foreignId('areas_de_conhecimento_id')
                    ->constrained('areas_de_conhecimentos')
                    ->onDelete('cascade')
                    ->name('areas_conhecimentos_ativ_extra_areas_conhecimentos_id_foreign');
            $table->foreignId('atividades_extracurriculares_id')
                    ->constrained('atividades_extracurricularres')
                    ->onDelete()
                    ->name('areas_conhecimentos_ativ_extra_ativ_extra_id_foreign');
        });


        Schema::create('areas_de_conhecimento_disciplina', function (Blueprint $table){
            $table->foreignId('areas_de_conhecimento_id')
                    ->constrained('areas_de_conhecimentos')
                    ->onDelete('cascade')
                    ->name('areas_conhecimentos_disciplina_areas_conhecimentos_id_foreign');
            $table->foreignId('disciplina_id')
                    ->constrained('disciplinas')
                    ->onDelete('cascade');
        });


        Schema::create('acervo_areas_de_conhecimento', function (Blueprint $table){
            $table->foreignId('acervo_id')
                    ->constrained('acervos')
                    ->onDelete('cascade');
            $table->foreignId('areas_de_conhecimento_id')
                    ->constrained('areas_de_conhecimentos')
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
        Schema::dropIfExists('aluno_areas_de_conhecimento');
        Schema::dropIfExists('parametros_para_sugerir_curso');
        Schema::dropIfExists('parametro_para_sugerir_atividade_extracurricular');
        Schema::dropIfExists('areas_de_conhecimento_atividades_extracurricular');
        Schema::dropIfExists('areas_de_conhecimento_disciplina');
        Schema::dropIfExists('acervo_areas_de_conhecimento');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
