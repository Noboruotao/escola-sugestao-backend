<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\Pessoa;
use App\Models\Endereco;
use App\Models\Aluno;
use App\Models\Professor;
use App\Models\Curso;
use App\Models\Periodo;
use App\Models\Responsavel;
use Spatie\Permission\Models\Role;


class PessoaFactory extends Factory
{
    public function definition()
    {
        dump('Starting Pessoa seeding');
        self::createPessoas();
        self::attributeEndereco();
    }

    public static function createPessoas()
    {

        echo 'createPessoas' . PHP_EOL;
        $faker = \Faker\Factory::create('pt_BR');

        //Administrador
        echo '    Administrador' . PHP_EOL;
        self::makePessoa(['Administrador'], 60, 30, $faker);

        //Diretor
        echo '    Diretor' . PHP_EOL;
        self::makePessoa(['Diretor'], 60, 40, $faker);

        //Bibliotecario
        echo '    Bibliotecario' . PHP_EOL;
        for ($i = 0; $i < 5; $i++) {
            self::makePessoa(['Bibliotecário'], 60, 20, $faker);
        }

        //Professor
        echo '    Professor' . PHP_EOL;
        for ($i = 0; $i < 50; $i++) {
            $roles = $faker->boolean(10) ?
                ['Professor', 'Responsável']
                : ['Professor'];
            self::makePessoa($roles, 60, 25, $faker);
        }
        self::createProfessor();

        //alunos ensino infantil
        echo '    alunos ensino infantil' . PHP_EOL;
        for ($i = 0; $i < 60; $i++) {
            self::makePessoa(['Aluno'], 5, 4, $faker);
        }
        //alunos ensino fundamental
        echo '    alunos ensino fundamental' . PHP_EOL;
        for ($i = 0; $i < 360; $i++) {
            self::makePessoa(['Aluno'], 15, 5, $faker);
        }
        //alunos ensino medio
        echo '    alunos ensino medio' . PHP_EOL;
        for ($i = 0; $i < 150; $i++) {
            self::makePessoa(['Aluno'], 18, 14, $faker);
        }
        self::createAlunos();

        //Responsavel
        echo '    Responsavel' . PHP_EOL;
        for ($i = 0; $i < Aluno::count() * 0.9; $i++) {
            self::makePessoa(['Responsável'], 50, 25, $faker);
        }
        self::createPais();
    }


    protected function makePessoa($roles, $maxIdade, $minIdade = 4, $faker)
    {
        $gender = $faker->randomElement(['Masculino', 'Feminino']);
        $firstName = $faker->firstName($gender == 'Masculino' ? 'male' : 'female');
        $lastName = $faker->lastName;
        $data_nascimento = $faker->dateTimeBetween("-$maxIdade years", "-$minIdade years")->format('Y-m-d');
        $idade = self::getIdade($data_nascimento);

        $pessoa = Pessoa::create([
            'nome' => "$firstName $lastName",
            'primeiro_nome' => $firstName,
            'ultimo_nome' => $lastName,
            'email' => $faker->unique()->email,
            'data_nascimento' => $data_nascimento,
            'genero' => $gender,
            'cpf' => $faker->unique()->numerify('###.###.###-##'),
            'rg' => $faker->unique()->numerify('##.###.###-#'),
            'telefone_1' => $faker->numerify('(##) ####-####'),
            'telefone_2' => $faker->numerify('(##) ####-####'),
            'senha' => \Illuminate\Support\Facades\Hash::make('password'),
            'foto' => self::getFoto($gender, $idade),
        ]);

        foreach ($roles as $role) {
            $pessoa->assignRole($role);
        }
    }


    protected function createProfessor()
    {
        $cursos = Curso::pluck('nome');
        foreach (Pessoa::role('Professor')->get() as $professor) {
            $curso = $cursos->random();
            $professores[] = [
                'id' => $professor->id,
                'experiencia_profissional' => "Formado em $curso",
            ];
        }
        Professor::insert($professores);
    }


    protected function createAlunos()
    {
        $nivelEscolarToNumber = [
            1 => 30,
            2 => 40,
            3 => 50,
        ];

        foreach (Periodo::all() as $periodo) {
            $number = $nivelEscolarToNumber[$periodo->nivel_escolar_id] ?? 0;

            $alunos = Pessoa::role('Aluno')
                ->whereDoesntHave('aluno')
                ->orderBy('data_nascimento', 'desc')
                ->limit($number)
                ->get();

            foreach ($alunos as $aluno) {
                Aluno::create([
                    'id' => $aluno->id,
                    'periodo_id' => $periodo->id,
                    'situacao_id' => 11,
                ]);
            }
        }
    }


    protected function createPais()
    {
        $pais = Pessoa::role('Responsável')->inRandomOrder()->get();
        Pessoa::role('Aluno')->chunk(200, function (Collection $alunos) use (&$pais) {
            foreach ($alunos as $aluno) {
                if ($pais->isEmpty()) {
                    $pais = Pessoa::role('Responsável')->inRandomOrder()->get();
                }
                Responsavel::attributeAlunoResponsavel($aluno->id, $pais->first()->id);
                $pais->shift();
            }
        });
    }


    protected function getIdade($birthday)
    {
        $currentDate = new \DateTime();
        $birthdayDate = \DateTime::createFromFormat('Y-m-d', $birthday);
        $ageInterval = $currentDate->diff($birthdayDate);
        return $ageInterval->y;
    }


    protected function getFoto($gender, $age)
    {
        $fotos = config('seeder_datas.pessoaFoto');
        $prefix = '';

        if ($gender == 'Masculino') {
            $prefix = ($age <= 16) ? 'boy_' : ($age < 40 ? 'youngman_' : 'man_');
        } else if ($gender == 'Feminino') {
            $prefix = ($age <= 16) ? 'girl_' : ($age < 40 ? 'youngwoman_' : 'woman_');
        }

        $filteredArray = array_filter($fotos, function ($value) use ($prefix) {
            return strpos($value, $prefix) === 0;
        });

        if (empty($filteredArray)) {
            return null;
        }

        $randomKey = array_rand($filteredArray);
        return $fotos[$randomKey];
    }


    private static function attribuirPessoaEndereco($pessoa)
    {
        $endereco = self::createEndereco();
        $pessoa->enderecos()->attach($endereco);
    }


    private static function attributeProtegidoEndereco($responsavel)
    {
        foreach ($responsavel->protegidos as $protegido) {
            $protegido->pessoa->enderecos()->attach($responsavel->enderecos->first());
        }
    }


    private static function attributeEndereco()
    {
        $alunoRole = Role::where('name', 'aluno')->first();
        Pessoa::whereDoesntHave('roles', function ($query) use ($alunoRole) {
            $query->where('role_id', $alunoRole->id);
        })->chunk(100, function (Collection $adultos) {
            foreach ($adultos as $adulto) {
                self::attribuirPessoaEndereco($adulto);
                if ($adulto->has('protegidos')->exists()) {
                    self::attributeProtegidoEndereco($adulto);
                }
            }
        });
    }


    public static function createEndereco()
    {
        $faker = \Faker\Factory::create('pt_BR');
        return Endereco::create([
            'cep' => $faker->postcode,
            'rua' => $faker->streetName,
            'bairro' => $faker->secondaryAddress,
            'numero' => $faker->buildingNumber,
            'cidade' => $faker->city,
            'uf' => $faker->stateAbbr,
            'complemento' => $faker->optional()->secondaryAddress,
        ]);
    }
}
