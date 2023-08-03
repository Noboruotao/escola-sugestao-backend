<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Pessoa;
use Spatie\Permission\Models\Role;


class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        dump('Starting Pessoa seeding');
        PessoaFactory::createAdmin();
    }


    protected static function createAdmin()
    {
        $administrador = Pessoa::create([
            'nome' => 'Administrador',
            'primeiro_nome' => 'Administrador',
            'ultimo_nome' => 'admin',
            'email' => 'admin@email.com',
            'data_nascimento' => '1997-07-01',
            'genero' => 'Masculino',
            'cpf' => '000.000.000-01',
            'rg' => '00.000.000-1',
            'telefone_1' => '(00)0000-0000',
            'telefone_2' => '(00)00000-0000',
            'senha' => \Illuminate\Support\Facades\Hash::make('password'),
            'foto' => 'admin1_02082023.png'
        ]);

        $administrador->assignRole('Administrador');
    }


    protected static function created
}
