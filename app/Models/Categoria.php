<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Models\Acervo;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['categoria'];
    public $timestamps = false;


    public function acervos()
    {
        return $this->hasMany(
            Acervo::class,
            'categoria_id',
            'id'
        );
    }


    public function getCategorias(
        $offset,
        $limit,
        $search
    ) {
        if (Cache::get('acervoCategoria') && !$limit) {
            $categorias = Cache::get('acervoCategoria');
        } else {
            $categorias = self::orderBy('categoria')
                ->when($limit, function ($query) use ($limit, $offset) {
                    return $query->offset($offset * $limit)
                        ->limit($limit);
                })
                ->where(
                    'categoria',
                    'like',
                    '%' . $search . '%'
                )
                ->get();
            Cache::put(
                'acervoCategoria',
                $categorias,
                now()->addMinutes(30)
            );
        }

        return response()->json([
            'success' => true,
            'data' => $categorias,
            'count' => self::count()
        ]);
    }


    public function createCategoria($data)
    {
        $categoria = Categoria::create($data);
        return response()->json([
            'success' => true,
            'data' => $categoria
        ]);
    }


    public function getAcervosByCategoria(
        $id,
        $offset,
        $limit
    ) {

        $acervoCategoria = Acervo::where('categoria_id', $id)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $acervoCategoria
        ]);
    }


    public function deleteCategoria($id)
    {
        Categoria::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Categoria Deleted'
        ]);
    }
}
