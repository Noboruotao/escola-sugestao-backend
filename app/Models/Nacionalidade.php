<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nacionalidade extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'nacionalidade',
        'idioma_oficial_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];


    public function idioma()
    {
        return $this->belongsTo(Idioma::class, 'idioma_id', 'id');
    }
}
