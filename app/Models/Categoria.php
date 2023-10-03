<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Acervo;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['categoria'];
    public $timestamps = false;


    public function acervos()
    {
        return $this->hasMany(Acervo::class, 'categoria_id', 'id');
    }


    public function getCategorias($offset = 0, $limit = null)
    {
        return Categoria::orderBy('categoria')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }


    public function createCategoria($data)
    {
        return Categoria::create($data);
    }


    public function getAcervosByCategoria($id, $offset, $limit)
    {

        return Acervo::where('categoria_id', $id)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }


    public function deleteCategoria($id)
    {
        return Categoria::find($id)->delete();
    }
}
