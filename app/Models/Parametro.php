<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    use HasFactory;

    protected $fillable = ['valor'];

    public function area()
    {
        return $this->belongsTo(AreaDeConhecimento::class, 'area_id');
    }
}
