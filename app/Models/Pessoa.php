<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'data_nascimento',
        'genero',
        'cpf',
        'rg',
        'telefone_1',
        'telefone_2',
        'senha',
        'foto'
    ];

    protected $hidden = [
        'primeiro_nome',
        'ultimo_nome',
        'data_nascimento',
        'genero',
        'telefone_1',
        'telefone_2',
        'senha',
        'foto'
    ];

    public function enderecos()
    {
        return $this->belongsToMany(Endereco::class, 'endereco_pessoa');
    }

    public function aluno()
    {
        return $this->hasOne(Aluno::class, 'id', 'id');
    }

    public function professor()
    {
        return $this->hasOne(Professor::class, 'id', 'id');
    }


    public function responsavel()
    {
        return $this->aluno->responsavel();
    }


    public function protegidos()
    {
        return $this->belongsToMany(Aluno::class, 'responsavel', 'responsavel_id', 'aluno_id');
    }


    public function bibliotecaMulta()
    {
        return $this->morphedByMany(Emprestimo::class, 'multas');
    }


    public function PagamentoMulta()
    {
        return $this->morphedByMany(Pagamento::class, 'multas');
    }
}
