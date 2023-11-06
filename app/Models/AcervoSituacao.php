<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcervoSituacao extends Model
{
    use HasFactory;

    protected $table = 'situacao_acervo';
    protected $fillable = ['situacao'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public const DISPONIVEL = 1;
    public const EMPRESTADO = 2;
    public const RESERVADO = 3;
    public const EM_PROCESSAMENTO_TECNICO = 4;
    public const EM_MANUTENCAO = 5;
    public const EXTRAVIADO = 6;
    public const DESCARTADO = 7;


    function listSituacao($page, $limit, $search)
    {

        $situacoes = self::where('situacao', 'like', '%' . $search . '%')
            ->when($limit,
             function ($query) use ($limit, $page) {
                return $query->offset($page * $limit)
                    ->limit($limit);
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $situacoes,
            'count' => self::count()
        ]);
    }
}
