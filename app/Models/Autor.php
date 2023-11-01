<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'nacionalidade_id',
        'ano_nascimento',
        'ano_falecimento'
    ];


    public function nacionalidade()
    {
        return $this->belongsTo(Nacionalidade::class);
    }


    public function acervos()
    {
        return $this->hasMany(Acervo::class);
    }


    public function getAutors($offset, $limit, $search)
    {
        $autors = self::where('nome', 'like', '%' . $search . '%')
            ->when($limit, function ($query) use ($limit, $offset) {
                return $query
                    ->offset($offset * $limit)
                    ->limit($limit);
            })
            ->with('nacionalidade')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $autors,
            'count' => self::count()
        ]);
    }


    public function getAutorById($id, $com_acervos = false)
    {

        $autor = Autor::when($com_acervos, function ($query) {
            return $query->with(['nacionalidade', 'acervos']);
        })
            ->find($id);

        if (!$autor) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Autor Não Encontrado'
                ],
                400
            );
        }

        return response()->json([
            'success' => true,
            'data' => $autor
        ], 200);
    }


    public function createAutor($data)
    {
        $autor = Autor::create($data);
        return $autor;
    }


    public function deleteAutor($id)
    {
        return Autor::find($id)->delete();
    }
}
