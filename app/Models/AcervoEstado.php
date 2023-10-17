<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcervoEstado extends Model
{
    use HasFactory;

    protected $table = 'estado_acervo';

    protected $fillable = ['estado'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    function listEstado($page = 0, $limit = null, $search = '')
    {

        $estados = self::where('estado', 'like', '%' . $search . '%')
            ->when($limit, function ($query) use ($page, $limit) {
                return $query->offset($page * $limit)
                    ->limit($limit);
            })
            ->get();


        return response()->json([
            'success' => true,
            'data' => $estados,
            'count' => self::count()
        ]);
    }
}
