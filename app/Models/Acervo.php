<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

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
        return $this->morphToMany(
            AreaConhecimento::class,
            'model',
            'model_has_areas',
            'model_id',
            'area_codigo'
        );
    }


    public function materialSugerido()
    {
        return $this->belongsToMany(
            Disciplina::class,
            'materiais_sugeridos'
        );
    }


    public function emprestimos()
    {
        return $this->hasMany(
            Emprestimo::class,
            'acervo_id',
            'id'
        );
    }


    public function getAcervo($acervo_id)
    {
        $acervo = self::with([
            'autor:id,nome',
            'editora:id,nome',
            'idioma:id,idioma',
            'categoria:id,categoria',
            'tipo:id,tipo',
            'estado:id,estado',
            'situacao:id,situacao'
        ])
            ->find($acervo_id);

        return response()->json([
            'success' => true,
            'data' => $acervo
        ]);
    }


    public function getAcervoList(
        $page = 0,
        $limit = 10,
        $sortColumn,
        $sortOrder,
        $search = null
    ) {
        $query = self::select([
            'id',
            'titulo',
            'subtitulo',
            'resumo',
            'capa',
            'autor_id',
            'situacao_id'
        ])
            ->with(['autor:id,nome'])
            ->with('situacao')
            // ->with(['emprestimos' => function ($query) {
            //     $query->whereNull('data_devolucao');
            // }])
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('titulo', 'like', '%' . $search . '%')
                        ->orWhere('resumo', 'like', '%' . $search . '%')
                        ->orWhere('subtitulo', 'like', '%' . $search . '%');
                });
            })
            ->orderBy($sortColumn, $sortOrder);

        if (!auth()->user()
            ->hasRole('Bibliotecário')) {
            $query->whereNotIn('situacao_id', [
                AcervoSituacao::EM_PROCESSAMENTO_TECNICO,
                AcervoSituacao::EM_MANUTENCAO,
                AcervoSituacao::EXTRAVIADO,
                AcervoSituacao::DESCARTADO
            ]);
        }

        $totalResults = $query->count();
        $results = $query
            ->skip($page * $limit)
            ->take($limit)
            ->get();


        return response()->json([
            'success' => true,
            'data' => $results,
            'count' => $totalResults
        ], 200);
    }

    public function getCapa($capa){
        try {
            $capaNome = $capa;
            $filePath = 'capas/' . $capaNome;
            $fileContents = Storage::get($filePath);
            $fileType = Storage::mimeType($filePath);
            if ($fileContents) {
                return response()->make(
                    $fileContents,
                    200,
                    [
                        'Content-Type' => $fileType,
                        'Content-Disposition' => 'inline; filename="' . $capa . '"',
                    ]
                );
            } else {
                return response()->make('File not found.', 404);
            }
        } catch (\Throwable $th) {
            return response()->make(
                $th->getMessage('nao encontrado'),
                404
            );
        }
    }


    function getAcervoParametros()
    {
        if (Cache::get('acervoParametros')) {
            return Cache::get('acervoParametros');
        }

        $response = response()->json([
            'success' => true,
            'estados' => AcervoEstado::get(),
            'categorias' => Categoria::get(),
            'tipos' => acervoTipo::get(),
            'situacoes' => AcervoSituacao::get(),
            'idiomas' => Idioma::get(),

        ]);

        Cache::put(
            'acervoParametros',
            $response
        );
        return $response;
    }


    public static function createCapa(
        $acervo,
        $file
    ) {
        try {

            if (!$file) {
                return config('seeder_datas.acervoCapa.' . $acervo->tipo_id);
            }

            $path = $file->store('capas', 'local');

            $filename = pathinfo(
                $path,
                PATHINFO_FILENAME
            );
            $extension = pathinfo(
                $path,
                PATHINFO_EXTENSION
            );
            $originalFilename = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            );
            $uniqueFilename = $originalFilename . '_' . $acervo->id . '_' . now()->format('YmdHis') . '.' . $extension;

            $newPath = str_replace(
                $filename,
                $uniqueFilename,
                $path
            );
            Storage::move(
                $path,
                'capas/' . $uniqueFilename
            );

            return $uniqueFilename;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function createAcervo(
        $data,
        $capa
    ) {
        try {
            $acervo = new Acervo();

            $acervo->titulo  = $data['titulo'];
            $acervo->subtitulo  = $data['subtitulo'];
            $acervo->resumo  = $data['resumo'];
            $acervo->tradutor = $data['tradutor'];
            $acervo->autor_id  = $data['autor_id'];
            $acervo->idioma_id  = $data['idioma_id'];
            $acervo->editora_id  = $data['editora_id'];
            $acervo->categoria_id = $data['categoria_id'];
            $acervo->tipo_id = $data['tipo_id'];
            $acervo->estado_id = $data['estado_id'];
            $acervo->situacao_id  = $data['situacao_id'];
            $acervo->IBNS = $data['IBNS'];
            $acervo->ano_publicacao = $data['ano_publicacao'];
            $acervo->edicao = $data['edicao'];
            $acervo->data_aquisicao = now()->format('Y-m-d');

            $acervo->capa = self::createCapa(
                $acervo,
                $capa
            );

            $acervo->save();

            return response()->json([
                'success' => true,
                'data' => $acervo
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao Cadastrar Acervo: ' . $th->getMessage()
            ], 400);
        }
    }


    public function getAcervosBySituacao(
        $situacao_id,
        $offset,
        $limit
    ) {
        $acervos = self::where('situacao_id', $situacao_id)
            ->offset($offset)
            ->limit($limit)
            ->get();
        return response()->json([
            'success' => true,
            'data' => $acervos
        ]);
    }
}
