<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAtividadeExtracurricularesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('tipos_de_atividade_extracurricular', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
        });

        \App\models\AtivExtraTipo::insert(config('seeder_datas.tipoAtivExtra'));


        Schema::create('atividade_extracurriculares', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('tipo_id')
                ->constrained('tipos_de_atividade_extracurricular');
            $table->boolean('ativo')
                ->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        \App\Models\AtividadeExtra::insert(config('seeder_datas.ativExtra'));


        Schema::create('aluno_atividades_extracurriculares', function (Blueprint $table) {
            $table->foreignId('aluno_id')
                ->constrained('alunos')
                ->onDelete('cascade');
            $table->foreignId('atividades_extracurriculares_id')
                ->constrained('atividade_extracurriculares')
                ->onDelete('cascade')
                ->name('aluno_ativ_extra_atividade_extracurricular_id_foreign');
            $table->integer('ativo')
                ->default(1)
                ->nullable();
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
        Schema::dropIfExists('aluno_atividade_extracurricular');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
