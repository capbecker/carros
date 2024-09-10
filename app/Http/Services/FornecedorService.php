<?php

namespace App\Http\Services;

use App\Models\Veiculo;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SimpleXMLElement;
use Carbon\Carbon;

class FornecedorService
{
    public function filterFornecedores($request)
    {
        $query = Fornecedor::query();
        return $query->get();
    }

    public function createFornecedor(array $data)
    {
        $fornecedor = new Fornecedor($data);
        $fornecedor->save();
        return $fornecedor;
    }

    public function updateFornecedor($id, array $data)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->fill($data);
        $fornecedor->save();
        return $fornecedor;
    }
}
