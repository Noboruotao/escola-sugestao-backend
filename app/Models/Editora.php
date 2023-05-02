<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editora extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id', 'id');
    }
}
