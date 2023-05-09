<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class Pessoa extends Authenticatable
{
    use HasFactory;
    use hasRoles;
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'primeiro_nome',
        'ultimo_nome',
        'email',
        'data_de_nascimento',
        'genero',
        'cpf',
        'rg',
        'endereco',
        'telefone',
        'celular',
        'senha',
        'foto',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'data_de_nascimento' => 'date',
        'telefone' => 'string',
        'celular' => 'string',
    ];


    
    public function getPessoaByCpf($cpf)
    {
        return Pessoa::where('cpf', $cpf)->first();
    }
    

    protected function getPessoaByRole($role_name)
    {
        return  Pessoa::whereNotNull('deleted_at')
            ->whereHas('roles', function ($query) use ($role_name) {
                $query->where('name', $role_name);
            })->get();
    }
}
