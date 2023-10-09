<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Acervo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'subtitulo',
        'resumo',
        'tradutor',
        'autor_id',
        'idioma_id',
        'editora_id',
        'categoria_id',
        'tipo_id',
        'estado_id',
        'situacao_id',
        'IBNS',
        'ano_publicacao',
        'capa',
        'edicao',
        'data_aquisicao'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }


    public function idioma()
    {
        return $this->belongsTo(Idioma::class);
    }


    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }


    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }


    public function tipo()
    {
        return $this->belongsTo(AcervoTipo::class);
    }


    public function estado()
    {
        return $this->belongsTo(AcervoEstado::class);
    }


    public function situacao()
    {
        return $this->belongsTo(AcervoSituacao::class);
    }


    public function areas()
    {
        return $this->morphToMany(AreaConhecimento::class, 'model', 'model_has_areas', 'model_id', 'area_codigo');
    }


    public function materialSugerido()
    {
        return $this->belongsToMany(Disciplina::class, 'materiais_sugeridos');
    }


    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class, 'acervo_id', 'id');
    }


    public function getAcervo($acervo_id)
    {
        return self::with([
            'autor:id,nome',
            'editora:id,nome',
            'idioma:id,idioma',
            'categoria:id,categoria',
            'tipo:id,tipo',
            'estado:id,estado',
            'situacao:id,situacao'
        ])
            ->find($acervo_id);
    }


    public function getAcervoList($page = 0, $limit = 10, $disponivel = true, $sortColumn = 'id', $sortOrder = 'asc', $search = null)
    {
        $query = self::select(['id', 'titulo', 'subtitulo', 'resumo', 'capa', 'autor_id'])
            ->with(['autor:id,nome'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('titulo', 'like', '%' . $search . '%')
                        ->orWhere('resumo', 'like', '%' . $search . '%')
                        ->orWhere('subtitulo', 'like', '%' . $search . '%');
                });
            })
            ->orderBy($sortColumn, $sortOrder);

        if ($disponivel) {
            $query->whereNotIn('situacao_id', [
                AcervoSituacao::EM_PROCESSAMENTO_TECNICO,
                AcervoSituacao::EM_MANUTENCAO,
                AcervoSituacao::EXTRAVIADO,
                AcervoSituacao::DESCARTADO
            ]);
        }

        $query->with(['emprestimos' => function ($query) {
            $query->whereNull('data_devolucao');
        }]);

        $totalResults = $query->count();
        $results = $query
            ->skip($page * $limit)
            ->take($limit)
            ->get();

        return [
            'data' => $results->toArray(),
            'count' => $totalResults
        ];
    }





    public function createCapa($acervo, $file)
    {
        try {
            $path = $file->store('capas', 'local');

            $filename = pathinfo($path, PATHINFO_FILENAME);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $uniqueFilename = $originalFilename . '_' . $acervo->id . '_' . now()->format('YmdHis') . '.' . $extension;

            $newPath = str_replace($filename, $uniqueFilename, $path);
            Storage::move($path, 'capas/' . $uniqueFilename);

            return $uniqueFilename;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function createAcervo($data)
    {
        return self::create($data);
    }





    public function getAcervosBySituacao($situacao_id, $offset, $limit)
    {
        return self::where('situacao_id', $situacao_id)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function getAllAcervoLength($search = null)
    {
        return self::whereNotIn('situacao_id', [
            AcervoSituacao::EM_PROCESSAMENTO_TECNICO,
            AcervoSituacao::EM_MANUTENCAO,
            AcervoSituacao::EXTRAVIADO,
            AcervoSituacao::DESCARTADO
        ])
            ->when($search, function ($query, $search) {
                return $query->where('titulo', 'like', '%' . $search . '%');
            })->count();
    }
}
