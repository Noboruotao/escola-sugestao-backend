<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AcervoTipo extends Model
{
    use HasFactory;


    public const LIVRO = 1;
    public const PERIODICOS = 2;
    public const TESE_DISERTACAO = 3;
    public const CD_DVD = 4;
    public const MAPA_ATLAS = 5;
    public const ARQUIVOS_DIGITAIS = 6;
    public const ACERVO_INFANTIL = 7;
    public const ACERVO_REFERENCIA = 8;
    public const COLECAO_ESPECIAL = 9;


    protected $table = 'tipo_acervo';
    protected $fillable = ['tipo', 'multa'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function acervos()
    {
        return $this->hasMany(Acervo::class, 'tipo_id');
    }

    function listAcervoTipos($page, $limit, $search)
    {
        if (Cache::get('acervoTipos')) {
            $acervoTipos = Cache::get('acervoTipos');
        } else {
            $acervoTipos = self::where('tipo', 'like', '%' . $search . '%')
                ->when($limit, function ($query) use ($page, $limit) {
                    return $query
                        ->offset($page * $limit)
                        ->limit($limit);
                })
                ->get();
            Cache::put(
                'acervoTipos',
                $acervoTipos,
                now()->addMinutes(30)
            );
        }

        return response()->json([
            'success' => true,
            'data' => $acervoTipos,
            'count' => self::count()
        ]);
    }
}
