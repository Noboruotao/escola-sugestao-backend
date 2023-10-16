<?php

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Database\Factories;

class CreateAreaDeConhecimentosTable extends Migration
{
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                Schema::create('areas_de_conhecimentos', function (Blueprint $table) {
                        // $table->id();
                        $table->string('codigo')
                                ->primary()
                                ->unique();
                        $table->string('nome');
                        $table->timestamps();
                });
                \App\Models\AreaConhecimento::insert(config('seeder_datas.CDU'));



                Schema::create('aluno_areas_de_conhecimento', function (Blueprint $table) {

                        $table->foreignId('aluno_id')
                                ->constrained('alunos')
                                ->onDelete('cascade');
                        $table->string('area_codigo');
                        $table->foreign('area_codigo')
                                ->references('codigo')
                                ->on('areas_de_conhecimentos')
                                ->onDelete('cascade');
                        $table->float('valor_notas')
                                ->default(NULL)
                                ->nullable();
                        $table->float('valor_acervos')
                                ->default(0)
                                ->nullable();
                        $table->float('valor_atividades')
                                ->default(0)
                                ->nullable();
                        $table->float('valor_respondido')
                                ->default(0)
                                ->nullable();
                });


                Schema::create('parametros', function (Blueprint $table) {
                        $table->string('area_codigo');
                        $table->foreign('area_codigo')
                                ->references('codigo')
                                ->on('areas_de_conhecimentos')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('model_id');
                        $table->string('model_type');
                        $table->float('valor');
                });


                Schema::create('model_has_areas', function (Blueprint $table) {
                        $table->string('area_codigo');
                        $table->foreign('area_codigo')
                                ->references('codigo')
                                ->on('areas_de_conhecimentos')
                                ->onDelete('cascade');
                        $table->string('model_id');
                        $table->string('model_type');
                });
                Factories\AreaFactory::attributeAreaAtviExtra();

                Factories\AreaFactory::attributeAreaDisciplina();
                Factories\AreaFactory::generateCursoSugestao();
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
                Schema::dropIfExists('aluno_areas_de_conhecimento');
                Schema::dropIfExists('parametros');
                Schema::dropIfExists('model_has_areas');
                Schema::dropIfExists('areas_de_conhecimentos');

                // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
}
