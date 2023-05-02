<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacaoAcervo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'situacao_do_acervo';
}
