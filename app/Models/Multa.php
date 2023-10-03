<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id',
        'multa_type',
        'multa_id',
        'mensagem',
        'dias_atrasados',
        'valor',
        'pago'
    ];

    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function emprestimos(){
        return $this->morphOne(Emprestimo::class, 'multas');
    }

}
