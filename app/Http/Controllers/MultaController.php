<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Multa;

class MultaController extends Controller
{
    public function __construct(Multa $multa)
    {
        $this->multa = $multa;
    }


    public function getMultas(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page = $request->query('page', 0);
        $pago = $request->query('pago', false);
        $search = $request->query('search', '');

        return $this->multa->getMultas($pago, $page, $limit, $search);
    }

    public function getMulta(Request $request, $id)
    {
        return $this->multa->getMulta($id);
    }
}
