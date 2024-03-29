<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

use Tymon\JWTAuth\Contracts\JWTSubject;

class Pessoa extends Authenticatable implements JWTSubject
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
        'senha',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function enderecos()
    {
        return $this->belongsToMany(
            Endereco::class,
            'endereco_pessoa'
        );
    }

    public function aluno()
    {
        return $this->hasOne(
            Aluno::class,
            'id',
            'id'
        );
    }

    public function professor()
    {
        return $this->hasOne(
            Professor::class,
            'id',
            'id'
        );
    }


    public function responsavel()
    {
        return $this->aluno
            ->responsavel();
    }


    public function protegidos()
    {
        return $this->belongsToMany(
            Aluno::class,
            'responsavel',
            'responsavel_id',
            'aluno_id'
        );
    }


    public function bibliotecaMulta()
    {
        return $this->morphedByMany(
            Emprestimo::class,
            'multas'
        );
    }


    public function PagamentoMulta()
    {
        return $this->morphedByMany(
            Pagamento::class,
            'multas'
        );
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }


    public function getPessoaByEmail($email)
    {
        return Pessoa::where('email', $email)
            ->whereNull('deleted_at')
            ->first();
    }

    public function getFoto($id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'O id é obrigatório'
            ], 400);
        }
        try {
            $foto = self::getFotoById($id);
            if (!$foto) {
                return response()
                    ->make(
                        'File not found.',
                        404
                    );
            }
            $filePath = 'fotos/' . $foto;
            $fileContents = Storage::get($filePath);
            $fileType = Storage::mimeType($filePath);
            if ($fileContents) {
                return response()->make(
                    $fileContents,
                    200,
                    [
                        'Content-Type' => $fileType,
                        'Content-Disposition' => 'inline; filename="' . $foto . '"',
                    ]
                );
            } else {
                return response()
                    ->make(
                        'File not found.',
                        404
                    );
            }
        } catch (\Throwable $th) {
            return response()->make(
                $th->getMessage(),
                404
            );
        }
    }


    public function getFotoById($id)
    {
        return Pessoa::find($id)->foto;
    }


    public function getPessoa($id)
    {
        $user = auth()->user();
        $pessoa = self::where('id', $id)
            ->when((!$user->can('pessoa.read') && $user->id != $id), function ($query) {
                return $query->select([
                    'id',
                    'nome',
                    'foto',
                    'data_nascimento'
                ]);
            })
            ->first();
        if ($pessoa->hasRole(['Aluno'])) {
            $pessoa->aluno
                ->situacao->situacao;
            $pessoa->aluno
                ->periodo->periodo;
        }
        if ($pessoa->hasRole(['Professor'])) {
            $pessoa->professor;
        }
        return [
            'success' => true,
            'data' => $pessoa
        ];
    }


    public function getPessoaListFilteredWithCpf(
        $search,
        $roles = [
            'Aluno'
        ]
    ) {
        $pessoasWithCpf = self::select([
            'nome',
            'id',
            'cpf'
        ])
            ->orderBy('nome')
            ->where('nome', 'like', "%$search%")
            ->orWhere('cpf', 'like', "%$search%")
            ->role($roles)
            ->limit(50)
            ->get();

        if ($pessoasWithCpf->count() != 0) {
            return response()->json([
                'success' => true,
                'data' => $pessoasWithCpf
            ]);
        }
        return response()->json(
            [
                'success' => false,
                'message' => 'Pessoa Não Encontrada'
            ],
            404
        );
    }
}
