<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDisciplinasTable extends Migration
{
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                Schema::create('disciplinas', function (Blueprint $table) {
                        $table->id();
                        $table->string('nome');
                        $table->integer('carga_horaria');
                        $table->timestamps();
                });
                \App\Models\Disciplina::insert(config('seeder_datas.disciplinas'));


                Schema::create('situacao_da_disciplina', function (Blueprint $table) {
                        $table->id();
                        $table->string('nome');
                });
                \App\Models\DisciplinaSituacao::insert(config('seeder_datas.situacao_da_disciplina'));


                Schema::create('aluno_Disciplina', function (Blueprint $table) {
                        $table->foreignId('aluno_id')
                                ->constrained('alunos')
                                ->onDelete('cascade');
                        $table->foreignId('disciplina_id')
                                ->constrained('disciplinas')
                                ->onDelete('cascade');
                        $table->foreignId('situacao_id')
                                ->constrained('situacao_da_disciplina');
                        $table->float('nota_final')
                                ->default(null)
                                ->nullable();
                });


                Schema::create('tipos_de_avaliacoes', function (Blueprint $table) {
                        $table->id();
                        $table->string('nome');
                });
                \App\Models\TipoAvaliacao::insert(config('seeder_datas.tipos_de_avaliacao'));


                Schema::create('notas', function (Blueprint $table) {
                        $table->id();
                        $table->foreignId('aluno_id')
                                ->constrained('alunos');
                        $table->foreignId('tipo_de_avaliacao_id')
                                ->constrained('tipos_de_avaliacoes');
                        $table->foreignId('disciplina_id')
                                ->constrained('disciplinas');
                        $table->float('nota')
                                ->onDelete('cascade');
                });



                Schema::create('materiais_sugeridos', function (Blueprint $table) {
                        $table->foreignId('disciplina_id')
                                ->constrained('disciplinas')
                                ->onDelete('cascade');
                        $table->foreignId('acervo_id')
                                ->constrained('acervos')
                                ->onDelete('cascade');
                });


                Schema::create('disciplina_periodo', function (Blueprint $table) {
                        $table->foreignId('periodo_id')
                                ->constrained('periodos')
                                ->onDelete('cascade');
                        $table->foreignId('disciplina_id')
                                ->constrained('disciplinas')
                                ->onDelete('cascade');
                });
                \Database\Factories\DisciplinaFactory::attributeDisciplinaPeriodo();
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
                Schema::dropIfExists('disciplinas');
                Schema::dropIfExists('aluno_Disciplina');
                Schema::dropIfExists('situacao_da_disciplina');
                // Schema::dropIfExists('disciplina_professor');
                Schema::dropIfExists('notas');
                Schema::dropIfExists('tipos_de_avaliacoes');
                Schema::dropIfExists('materiais_recomendados');
                // Schema::dropIfExists('ano_disciplina');

                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
}
