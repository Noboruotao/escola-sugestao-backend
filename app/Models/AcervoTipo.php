<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcervoTipo extends Model
{
    use HasFactory;

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
        $acervoTipos = self::where('tipo', 'like', '%' . $search . '%')
            ->when($limit, function ($query) use ($page, $limit) {
                return $query
                    ->offset($page * $limit)
                    ->limit($limit);
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $acervoTipos,
            'count' => self::count()
        ]);
    }
}
