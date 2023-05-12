<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AtividadesExtracurriculares extends Model
{
    use HasFactory;
    protected $table = 'atividade_extracurriculares';
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'tipo_id',
        'ativo'
    ];

    protected $guarded = [
        'id'
    ];


    public function areas()
    {
        return $this->belongsToMany(AreasDeConhecimento::class, 'parametro_para_sugerir_atividade_extracurricular')->withPivot('valor');
    } 
    
    
    public function alunos()
    {
        return $this->belongsToMany(alunos::class)->withPivot('ativo');
    }
}
