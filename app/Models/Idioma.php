<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    use HasFactory;

    protected $fillable = ['idioma'];


    function listIdiomas($page, $limit, $search)
    {
        $idiomas = self::where('idioma', 'like', '%' . $search . '%')
            ->when($limit, function ($query) use ($limit, $page) {
                return $query
                    ->offset($page * $limit)
                    ->limit($limit);
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $idiomas,
            'count' => self::count()
        ]);
    }
}
