<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acervo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
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
        'ano_de_publicacao'
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class, 'autor_id', 'id');
    }


    public function idioma()
    {
        return $this->belongsTo(Idioma::class, 'idioma_id', 'id');
    }


    public function editora()
    {
        return $this->belongsTo(Editora::class, 'editora_id', 'id');
    }


    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }


    public function tipo()
    {
        return $this->belongsTo(TipoAcervo::class, 'tipo_id', 'id');
    }


    public function estado()
    {
        return $this->belongsTo(EstadoAcervo::class, 'estado_id', 'id');
    }


    public function situacao()
    {
        return $this->belongsTo(SituacaoAcervo::class, 'situacao_id', 'id');
    }


    public function areas()
    {
        return $this->belongsToMany(AreasDeConhecimento::class);
    }


    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'materiais_sugeridos');
    }
}
