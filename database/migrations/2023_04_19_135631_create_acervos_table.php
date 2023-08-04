<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAcervosTable extends Migration
{
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                Schema::create('idiomas', function (Blueprint $table) {
                        $table->id();
                        $table->string('idioma');
                });
                \App\Models\Idioma::insert(config('seeder_datas.idiomas'));


                Schema::create('nacionalidades', function (Blueprint $table) {
                        $table->id();
                        $table->string('nacionalidade');
                        $table->foreignId('idioma_oficial_id')
                                ->constrained('idiomas')
                                ->onDelete('cascade');
                });
                \App\Models\Nacionalidade::insert(config('seeder_datas.nacionalidade'));


                Schema::create('autors', function (Blueprint $table) {
                        $table->id();
                        $table->string('nome');
                        $table->foreignId('nacionalidade_id')
                                ->constrained('nacionalidades')
                                ->onDelete('cascade');
                        $table->string('ano_nascimento', 4)
                                ->nullable();
                        $table->string('ano_falecimento', 4)
                                ->nullable();
                });
                \Database\Factories\AcervoFactory::createAutor(50);


                schema::create('editoras', function (Blueprint $table) {
                        $table->id();
                        $table->string('nome');
                        $table->string('email');
                        $table->string('telefone', 20);
                        $table->string('cnpj')->unique();
                        $table->foreignId('endereco_id');
                });
                \Database\Factories\AcervoFactory::createEditoras();


                Schema::create('situacao_do_acervo', function (Blueprint $table) {
                        $table->id();
                        $table->string('situacao');
                });
                \App\Models\AcervoSituacao::insert(config('seeder_datas.situacao_acervo'));


                Schema::create('estado_do_acervo', function (Blueprint $table) {
                        $table->id();
                        $table->string('estado');
                });
                \App\Models\AcervoEstado::insert(config('seeder_datas.estados_acervo'));


                Schema::create('tipo_de_acervo', function (Blueprint $table) {
                        $table->id();
                        $table->string('tipo');
                        $table->float('multa')
                                ->default(0.5);
                });
                \App\Models\AcervoTipo::insert(config('seeder_datas.tipos_acervo'));


                Schema::create('categorias', function (Blueprint $table) {
                        $table->id();
                        $table->string('categoria');
                });
                \App\Models\Categoria::insert(config('seeder_datas.categorias_acervo'));


                Schema::create('acervos', function (Blueprint $table) {
                        $table->id();
                        $table->string('titulo');
                        $table->string('subtitulo');
                        $table->text('resumo');
                        $table->string('tradutor');
                        $table->foreignId('autor_id')
                                ->constrained('autors')
                                ->onDelete('cascade');
                        $table->foreignId('idioma_id')
                                ->constrained('idiomas')
                                ->onDelete('cascade');
                        $table->foreignId('editora_id')
                                ->constrained('editoras')
                                ->onDelete('cascade');
                        $table->foreignId('categoria_id')
                                ->constrained('categorias')
                                ->onDelete('cascade');
                        $table->foreignId('tipo_id')
                                ->constrained('tipo_de_acervo')
                                ->onDelete('cascade');
                        $table->foreignId('estado_id')
                                ->constrained('estado_do_acervo')
                                ->onDelete('cascade');
                        $table->foreignId('situacao_id')
                                ->constrained('situacao_do_acervo')
                                ->onDelete('cascade');
                        $table->string('IBNS', 21)
                                ->nullable();
                        $table->string('ano_de_publicacao', 4);
                        $table->string('capa')
                                ->nullable()
                                ->default(null);
                        $table->string('edicao');
                        $table->date('data_aquisicao');
                        $table->timestamps();
                });


                Schema::create('emprestimos', function (Blueprint $table) {
                        $table->id();
                        $table->foreignId('acervo_id')
                                ->constrained('acervos')
                                ->onDelete('cascade');
                        $table->foreignId('bibliotecario_id')
                                ->constrained('pessoas')
                                ->onDelete('cascade');
                        $table->foreignId('leitor_id')
                                ->constrained('pessoas')
                                ->onDelete('cascade');
                        $table->date('data_emprestimo');
                        $table->date('data_devolucao')
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
                Schema::dropIfExists('acervos');
                Schema::dropIfExists('situacao_do_acervo');
                Schema::dropIfExists('estado_do_acervo');
                Schema::dropIfExists('tipo_de_acervo');
                Schema::dropIfExists('categoria');
                Schema::dropIfExists('autores');
                Schema::dropIfExists('nacionalidades');
                Schema::dropIfExists('idiomas');
                Schema::dropIfExists('editoras');
                Schema::dropIfExists('emprestimos');
                // Schema::dropIfExists('estados');

                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
}
