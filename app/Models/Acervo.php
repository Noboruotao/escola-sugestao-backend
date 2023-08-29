<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
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


    public static function getAcervoList($page = 0, $limit = 10, $disponivel = true)
    {
        $query = Acervo::orderBy('titulo')
            ->offset($page * $limit)
            ->limit($limit)
            ->with(['emprestimos' => function ($query) {
                $query->whereNull('data_devolucao');
            }]);

        if ($disponivel) {
            $query->whereNotIn('situacao_id', [6, 7]);
        }

        return $query->get();
    }


    public static function createCapa($acervo, $file)
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


    public static function createAcervo($data)
    {
        return Acervo::create($data);
    }





    public static function getAcervosBySituacao($situacao_id, $offset, $limit)
    {
        return Acervo::where('situacao_id', $situacao_id)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }
}
