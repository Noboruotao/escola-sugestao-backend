<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtivExtraTipo extends Model
{
    use HasFactory;
    protected $table = 'tipos_atividade_extracurricular';
    protected $fillable = ['nome'];


    public function getAtivExtraTipos()
    {
        return response()->json([
            'success' => true,
            'data' => self::get(),
            'count' => self::count(),
        ]);
    }
}
