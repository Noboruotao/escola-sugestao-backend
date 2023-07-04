<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'carga_horaria',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function areas()
    {
        return $this->belongsToMany(AreasDeConhecimento::class);
    }


    public function anos()
    {
        return $this->belongsToMany(Ano::class);
    }


    public function acervos()
    {
        return $this->belongsToMany(Acervo::class, 'materiais_sugeridos');
    }


    public static function hasAreasDeConhecimento($areaDeConhecimentoIds)
    {
        $areaDeConhecimentoIds = collect($areaDeConhecimentoIds)->flatten();

        return self::whereIn('id', function ($query) use ($areaDeConhecimentoIds) {
            $query->select('disciplina_id')
                ->from('areas_de_conhecimento_disciplina')
                ->whereIn('areas_de_conhecimento_id', $areaDeConhecimentoIds);
        })->get();
    }
}
