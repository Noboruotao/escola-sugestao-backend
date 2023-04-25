<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'professores';


    /**
     * acessar os dados de Pessoa com mesmo id
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id', 'id');
    }
}
