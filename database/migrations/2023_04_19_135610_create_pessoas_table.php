<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('primeiro_nome');
            $table->string('ultimo_nome');
            $table->string('email')->unique();
            $table->date('data_de_nascimento');
            $table->string('genero');
            $table->string('cpf', 14)->unique();
            $table->string('rg', 20)->unique();
            $table->string('endereco');
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('senha');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('professores', function (Blueprint $table){
            $table->foreignId('id')
                    ->constrained('pessoas')
                    ->onDelete('cascade');
            $table->text('formacao_academica');
            $table->text('experiencia_profissional');
        });


        Schema::create('situacao_aluno', function (Blueprint $table){
            $table->id();
            $table->string('situacao');
        });

        
        Schema::create('nivel_escolar', function (Blueprint $table){
            $table->id();
            $table->string('nome');
        });


        Schema::create('anos', function(Blueprint $table){
            $table->id();
            $table->foreignId('nivel_escolar_id')
                    ->constrained('nivel_escolar')
                    ->onDelete('cascade');
            $table->integer('ano');
        });


        Schema::create('alunos', function (Blueprint $table){
            $table->foreignId('id')
                    ->constrained('pessoas')
                    ->onDelete('cascade');
            $table->foreignId('ano_id')
                    ->constrained('anos')
                    ->onDelete('cascade');
            $table->foreignId('situacao_id')
                    ->constrained('situacao_aluno')
                    ->onDelete('cascade');
        });


        Schema::create('bolsas', function (Blueprint $table){
            $table->id();
            $table->string('nome');
            $table->float('valor');
        });


        Schema::create('alunos_bolsas' , function (Blueprint $table){
            $table->foreignId('aluno_id')
                    ->constrained('alunos')
                    ->onDelete('cascade');
            $table->foreignId('bolsa_id')
                    ->constrained('bolsas')
                    ->onDelete('cascade');
        });


        Schema::create('pais_ou_responsaveis', function (Blueprint $table){
            $table->foreignId('pais_ou_responsavel_id')
                    ->constrained('pessoas')
                    ->onDelete('cascade');
            $table->foreignId('aluno_id')
                    ->constrained('alunos')
                    ->inDelete('cascade');
        });


        Schema::create('mensalidades', function(Blueprint $table){
            $table->id();
            $table->foreignId('aluno_id');
            $table->float('valor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas');
        Schema::dropIfExists('professores');
        Schema::dropIfExists('situacao_aluno');
        Schema::dropIfExists('alunos');
        Schema::dropIfExists('bolsas');
        Schema::dropIfExists('alunos_bolsas');
        Schema::dropIfExists('nivel_escolar');
        Schema::dropIfExists('pais_ou_responsaveis');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
