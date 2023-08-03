<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'aluno_id',
        'valor',
        'validade',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }


    public function multa()
    {
        return $this->morphOne(Pessoa::class, 'multas');
    }
}
