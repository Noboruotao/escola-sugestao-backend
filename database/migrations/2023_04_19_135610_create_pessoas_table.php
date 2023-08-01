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
            $table->string('email')
                ->unique();
            $table->date('data_nascimento');
            $table->string('genero');
            $table->string('cpf', 14)
                ->unique();
            $table->string('rg', 20)
                ->unique();
            $table->string('telefone_1', 20)
                ->nullable();
            $table->string('telefone_2', 20)
                ->nullable();
            $table->string('senha');
            $table->string('foto')
                ->nullable()
                ->default(null);
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->string('cep');
            $table->string('rua');
            $table->string('bairro');
            $table->string('numero');
            $table->string('cidade');
            $table->string('uf');
            $table->string('complemento')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('endereco_pessoa', function (Blueprint $table) {
            $table->foreignId('endereco_id')
                ->constrained('enderecos')
                ->onDelete('cascade');
            $table->foreignId('pessoa_id')
                ->constrained('pessoas')
                ->onDelete('cascade');
        });


        Schema::create('professors', function (Blueprint $table) {
            $table->foreignId('id')
                ->constrained('pessoas')
                ->onDelete('cascade');
            $table->text('experiencia_profissional');
        });


        Schema::create('situacao_aluno', function (Blueprint $table) {
            $table->id();
            $table->string('situacao');
        });


        Schema::create('nivel_escolar', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
        });


        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nivel_escolar_id')
                ->constrained('nivel_escolar')
                ->onDelete('cascade');
            $table->integer('periodo');
        });


        Schema::create('alunos', function (Blueprint $table) {
            $table->foreignId('id')
                ->constrained('pessoas')
                ->onDelete('cascade');
            $table->foreignId('periodo_id')
                ->constrained('periodos')
                ->onDelete('cascade');
            $table->foreignId('situacao_id')
                ->constrained('situacao_aluno')
                ->onDelete('cascade');
        });


        Schema::create('bolsas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->float('valor');
        });


        Schema::create('aluno_bolsa', function (Blueprint $table) {
            $table->foreignId('aluno_id')
                ->constrained('alunos')
                ->onDelete('cascade');
            $table->foreignId('bolsa_id')
                ->constrained('bolsas')
                ->onDelete('cascade');
        });


        Schema::create('responsavel', function (Blueprint $table) {
            $table->foreignId('responsavel_id')
                ->constrained('pessoas')
                ->onDelete('cascade');
            $table->foreignId('aluno_id')
                ->constrained('alunos')
                ->inDelete('cascade');
        });


        Schema::create('mensalidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')
                ->constrained('alunos')
                ->onDelete('cascade');
            $table->float('valor');
            $table->date('validade');
            $table->date('pago')
                ->default(null)
                ->nullable();
        });


        Schema::create('multas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')
                ->constrained('pessoas')
                ->onDelete('cascade');
            $table->string('multa_type');
            $table->unsignedBigInteger('multa_id');
            $table->string('mensagem');
            $table->integer('dias_atrasados');
            $table->float('valor');
            $table->date('pago')
                ->default(NULL)
                ->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('professors');
        Schema::dropIfExists('situacao_aluno');
        Schema::dropIfExists('alunos');
        Schema::dropIfExists('bolsas');
        Schema::dropIfExists('aluno_bolsa');
        Schema::dropIfExists('nivel_escolar');
        Schema::dropIfExists('responsavel');
        Schema::dropIfExists('enderecos');
        Schema::dropIfExists('endereco_pessoa');
        Schema::dropIfExists('multas');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
