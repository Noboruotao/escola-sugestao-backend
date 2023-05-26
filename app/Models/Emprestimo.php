<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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


    public function updateAreaValue($areas_do_aluno, $areaId)
    {
        $area_do_aluno = $areas_do_aluno->firstWhere('id', $areaId);
        $area_do_aluno->pivot->increment('valor_calculado_pelo_emprestimo_de_acervo', 0.2);
    }

    public function insertAreaValue($alunoId, $areaId)
    {
        DB::table('aluno_areas_de_conhecimento')->insert([
            'aluno_id' => $alunoId,
            'areas_de_conhecimento_id' => $areaId,
            'valor_calculado_pelo_emprestimo_de_acervo' => 0.2
        ]);
    }

    public function updateAlunoAreas($leitor, $acervo)
    {
        $emprestimo = new Emprestimo();
        foreach ($acervo->areas as $area) {
            $areas_do_aluno = $leitor->areas;
            if ($areas_do_aluno->contains('id', $area->id)) {
                $emprestimo->updateAreaValue($areas_do_aluno, $area->id);
            } else {
                $existingRelation = DB::table('aluno_areas_de_conhecimento')
                    ->where('aluno_id', $leitor->id)
                    ->where('areas_de_conhecimento_id', $area->id)
                    ->exists();
                if (!$existingRelation) {
                    $emprestimo->insertAreaValue($leitor->id, $area->id);
                }
            }
        }
    }
}
