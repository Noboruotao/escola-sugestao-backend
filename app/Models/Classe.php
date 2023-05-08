<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['professor_id', 'disciplina_id'];
    protected $guarded = ['id'];

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
}
