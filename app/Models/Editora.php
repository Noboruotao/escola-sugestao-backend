<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editora extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cnpj',
        'endereco_id'
    ];


    public function endereco()
    {
        return $this->belongsTo(endereco::class);
    }

    public function acervos()
    {
        return $this->hasMany(
            Acervo::class,
            'editora_id'
        );
    }

    function listEditoras(
        $page,
        $limit,
        $search
    ) {
        $editoras = self::select(['id', 'nome'])
            ->where('nome', 'like', '%' . $search . '%')
            ->offset($page * $limit)
            ->limit($limit)
            ->get();

        return response()->json(

            [
                'success' => true,
                'data' => $editoras,
                'count' => self::count()
            ]
        );
    }

    function getEditoraById($id)
    {
        $editora = self::with('endereco')
            ->find($id);

        if (!$editora) {
            return response()->json([
                'success' => false,
                'message' => 'Editora Não Encontrada.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $editora
        ]);
    }
}
