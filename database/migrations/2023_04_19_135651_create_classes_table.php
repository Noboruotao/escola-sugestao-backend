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
                    ->constrained('professores');
            $table->foreignId('disciplina_id')
                    ->constrained('disciplinas');
            $table->timestamps();
        });


        Schema::create('alunos_classes', function (Blueprint $table){
            $table->foreignId('aluno_id')
                    ->constrained('alunos')
                    ->onDelete('cascade');
            $table->foreignId('classe_id')
                    ->constrained('classes')
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
        Schema::dropIfExists('classes');
        Schema::dropIfExists('alunos_classes');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
