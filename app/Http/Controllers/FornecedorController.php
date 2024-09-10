<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Services\FornecedorService;
use App\Models\Fornecedor;
use App\Http\Requests\FornecedorRequest;

use SimpleXMLElement;

class FornecedorController extends Controller
{
    protected $fornecedorService;

    public function __construct(FornecedorService $fornecedorService)
    {
        $this->fornecedorService = $fornecedorService;
    }

    /**
     * Pesquisa todos os veículos para a listagem.
     */
    public function index() 
    {
        $fornecedores = $this->fornecedorService->filterFornecedores(request());
        return view('fornecedor.index', ['fornecedores' => $fornecedores]);
    }

    public function create()
    {
        return view('fornecedor.form');
    }

    public function store(FornecedorRequest $request){
        $fornecedor = new Fornecedor;

        Log::info($request);
        try {
            $fornecedor = $this->fornecedorService->createFornecedor($request->all());

            return redirect('/fornecedor')->with('success', 'Fornecedor salvo com sucesso!');
        } catch (\Exception $e) {
            $msgErro='';
            if ($e->getCode() == 23000) {
                $msgErro='Fornecedor já existe na base de dados';
            } else { 
                $msgErro='Erro ao inserir';                
            }
            Log::error($e->getMessage());
            return redirect()->back()->withErrors($msgErro)->withInput();
        } 
    }

    public function edit($id) {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedor.form',['fornecedor'=> $fornecedor ]);
    }

    public function update(FornecedorRequest $request, $id)
    {
        try {
            $fornecedor = $this->fornecedorService->updateFornecedor($id, $request->all());

            return redirect('/fornecedor')->with('success', 'Fornecedor atualizado com sucesso!');
        } catch (\Exception $e) {
            $msgErro='';
            if ($e->getCode() == 23000) {
                $msgErro='Fornecedor já existe na base de dados';
            } else { 
                $msgErro='Erro ao atualizar';                
            }            
            Log::error($e->getMessage());
            return redirect()->back()->withErrors($msgErro)->withInput();
        }
    }

    public function destroy($id) 
    {
        try {
            Fornecedor::findOrFail($id)->delete();
            return redirect('/fornecedor')->with('success', 'Fornecedor excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir fornecedor: ' . $e->getMessage());
            return redirect('/fornecedor')->with('error', 'Erro ao excluir fornecedor: ' . $e->getMessage());
        }
    }

}