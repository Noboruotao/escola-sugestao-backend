<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_de_emprestimo',
        'data_de_devolucao'
    ];


    public function acervo()
    {
        return $this->belongsTo(Acervo::class, 'acervo_id', 'id');
    }


    public function bibliotecario()
    {
        return $this->belongsTo(Pessoa::class, 'bibliotecario_id', 'id');
    }


    public function leitor()
    {
        return $this->belongsTo(Pessoa::class, 'leitor_id', 'id');
    }


    public function updateAlunoAreas($leitor, $acervo)
    {
        $areas_do_aluno = $leitor->areas;
        foreach($acervo->areas as $area)
        {
            if ($areas_do_aluno->contains('id', $area->id)) {
                $area_do_aluno = $areas_do_aluno->firstWhere('id', $area->id);
                $area_do_aluno->pivot->valor_calculado_pelo_emprestimo_de_acervo += 0.2;
                $area_do_aluno->pivot->update(['valor_calculado_pelo_emprestimo_de_acervo' => $area_do_aluno->pivot->valor_calculado_pelo_emprestimo_de_acervo]);
            }else{

                $data = collect([[
                    'aluno_id'=> $leitor->id,
                    'areas_de_conhecimento_id'=> $area->id,
                    'valor_calculado_pelo_emprestimo_de_acervo'=> 0.2
                ]])->map(function($data){
                    return $data;
                });
        
                foreach(array_chunk($data->toArray(), 200) as $data_parts)
                {
                    \Illuminate\Support\Facades\DB::table('aluno_areas_de_conhecimento')->insert($data_parts);    
                }
            }
        }
    }
}
