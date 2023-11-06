<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Type\FalseType;

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

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }


    public function multa(): MorphTo
    {
        return $this->morphTo();
    }

    public function getMultas(
        $pago,
        $page,
        $limit,
        $search
    ) {

        $pago = $pago === 'true';
        $user = auth()->user();
        $query = self::select([
            'id',
            'mensagem',
            'multa_type',
            'pessoa_id',
            'dias_atrasados',
            'pago',
            'valor'
        ])
            ->orderByDesc("created_at")
            ->with('pessoa:id,nome')
            ->when($user->hasRole([
                'Aluno',
                'Professor'
            ]), function ($query) use ($user) {
                return $query->where('pessoa_id',  $user->id);
            })
            ->when($pago, function ($query) {
                return $query->whereNotNull('pago');
            })
            ->when(!$pago, function ($query) {
                return $query->whereNull('pago');
            })
            ->when($user->hasRole('Bibliotecário'), function ($query) {
                return $query->where('multa_type', Emprestimo::class);
            })
            ->when($user->hasRole('Secretaria'), function ($query) {
                return $query->whereNot('multa_type', Emprestimo::class);
            });

        if ($search !== '') {
            $query->whereHas('pessoa', function ($sub_query) use ($search) {
                $sub_query->where('nome', 'like', "%$search%");
            });
        }

        $count = $query->count();
        $multas = $query
            ->offset($page * $limit)
            ->limit($limit)
            ->get();


        $responseData = [
            'success' => $count !== 0,
            'message' => $count !== 0
                ? 'Multas encontradas.'
                : 'Não foram encontradas Multas.',
            'data' => $count !== 0
                ? $multas
                : [],
            'count' => $count,
        ];

        return response()->json(
            $responseData,
            $count !== 0
                ? 200
                : 400
        );
    }


    public function getMulta($id)
    {
        $user = auth()->user();
        $multa = self::with('pessoa:id,nome,email,telefone_1,telefone_2,foto')
            ->when($user->hasRole([
                'Aluno',
                'Professor'
            ]), function ($query) use ($user) {
                return $query->where('pessoa_id', $user->id);
            })
            ->find($id);

        if (!$multa) {
            return response()->json([
                'success' => false,
                'message' => 'Multa Não Encontrada'
            ]);
        }


        return response()->json([
            'success' => true,
            'data' => $multa
        ], 200);
    }


    public function pagarMulta($id)
    {
        $multa = self::find($id);
        if (!$multa) {
            return response()->json([
                'success' => false,
                'message' => 'Multa Não Encontrada.'
            ], 400);
        }
        if ($multa->pago != null) {
            return response()->json([
                'success' => false,
                'message' => 'Multa Já Paga.'
            ], 400);
        }

        $multa->update(['pago' => now()]);

        return response()->json([
            'success' => true,
            'data' => $multa,
        ], 200);
    }
}
