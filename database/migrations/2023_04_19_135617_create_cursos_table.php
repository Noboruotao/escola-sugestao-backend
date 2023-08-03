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
        \App\Models\Curso::insert(config('seeder_datas.cursos'));


        Schema::create('sugeridos', function (Blueprint $table) {
            $table->foreignId('aluno_id')
                ->constrained('alunos')
                ->onDelete('cascade');
            $table->unsignedBigInteger('sugerido_id');
            $table->string('sugerido_type');
            $table->date('desaparecer')
                ->default(null)
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
        Schema::dropIfExists('cursos');
        Schema::dropIfExists('sugeridos');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
