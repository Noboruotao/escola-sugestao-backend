<?php

namespace App\Models;

use Exception;
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


    public static function getAutors($offset, $limit)
    {
        return Autor::offset($offset * $limit)
            ->limit($limit)
            ->with('nacionalidade')
            ->get();
    }


    public static function getAutorById($id)
    {
        return Autor::with('acervos')
            ->find($id);
    }


    public static function createAutor($data)
    {
        $autor = Autor::create($data);
        return $autor;
    }


    public static function deleteAutor($id)
    {
        try {
            return Autor::find($id)->delete();
        } catch (Exception $e) {
            return $e;
        }
    }
}
