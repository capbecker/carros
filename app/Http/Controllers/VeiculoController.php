<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Services\VeiculoService;
use App\Models\Veiculo;
use App\Models\Opcional;
use App\Http\Requests\VeiculoRequest;

use SimpleXMLElement;

class VeiculoController extends Controller
{
    protected $veiculoService;

    public function __construct(VeiculoService $veiculoService)
    {
        $this->veiculoService = $veiculoService;
    }

    /*public function index($fornecedor_id) 
    {        
        $veiculos = $this->veiculoService->filterVeiculos($fornecedor_id, request());
        return view('veiculo.index', ['veiculos' => $veiculos, 'fornecedor_id'=>$fornecedor_id]);
    }

    public function filter($fornecedor_id, Request $request)
    {
        $veiculos = $this->veiculoService->filterVeiculos($request);
        return view('veiculo.index', ['veiculos' => $veiculos]);
    } */
   
        
    public function index($fornecedor_id, Request $request)
    {
        // Obter parâmetros de ordenação da requisição, com valores padrão
        $sortColumn = $request->input('sort_by', 'codigoVeiculo');
        $sortDirection = $request->input('sort_direction', 'asc');

        // Obter veículos do fornecedor com ordenação e paginação
        $veiculos = Veiculo::where('fornecedor_id', $fornecedor_id)
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);

        return view('veiculo.index', [
            'veiculos' => $veiculos,
            'fornecedor_id' => $fornecedor_id
        ]);
    }


    public function destroy($fornecedor_id, $id) 
    {       
        try {        
            $veiculo = Veiculo::where('fornecedor_id', $fornecedor_id)->where('id', $id)->firstOrFail();            
            
            $veiculo->delete();
            
            return redirect()->route('veiculo.index', ['fornecedor_id' => $fornecedor_id])
                            ->with('success', 'Veículo excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir veículo: ' . $e->getMessage());
            return redirect()->route('veiculo.index', ['fornecedor_id' => $fornecedor_id])
                            ->with('error', 'Erro ao excluir veículo: ' . $e->getMessage());
        }
    }

    public function view($fornecedor_id,$id) {
        $veiculo = Veiculo::with('opcionais')
            ->where('fornecedor_id', $fornecedor_id)
            ->where('id', $id)
            ->firstOrFail();
        return view('veiculo.view',['fornecedor_id'=>$fornecedor_id,'veiculo'=> $veiculo ]);
    }
    
    public function exportSingleVeiculo($fornecedor_id, $id)
    {
       return $this->veiculoService->exportSingleVeiculo($fornecedor_id, $id);       
    }


    public function exportFornecedorVeiculo($fornecedor_id, $id)
    {
       //return $this->veiculoService->exportSingleVeiculo($fornecedor_id, $id);
       return $this->veiculoService->exportVeiculo($fornecedor_id);
    }


    public function formImport($fornecedor_id,$id)
    {
        Log::Error('Chamando a view de importação com fornecedor_id: ' . $fornecedor_id);
        return view('veiculo.import',['fornecedor_id'=>$fornecedor_id]);
    }    

    /**
     * Método de importação
     * valida o tipo de documento - XML ou JSON - e faz a importação de acordo
     */
    public function import($fornecedor_id, Request $request)
    {
        // Validação para garantir que apenas um dos arquivos é enviado
        $request->validate([
            'file' => 'required|file',
            'file_type' => 'required|in:xml,json'
        ]);

        try {            
            // Obtenha o tipo de arquivo
            $fileType = $request->input('file_type');

            // Processa o arquivo com base no tipo
            if ($fileType === 'xml') {
                $file = $request->file('file');
                $this->veiculoService->importVeiculosFromXml($fornecedor_id,$file);
            } elseif ($fileType === 'json') {
                $file = $request->file('file');
                $this->veiculoService->importVeiculosFromJson($fornecedor_id,$file);
            } else {
                return redirect()->route('veiculo.index', ['fornecedor_id' => $fornecedor_id])
                    ->with('error', 'Tipo de arquivo não suportado!');
            }

            return redirect()->route('veiculo.index', ['fornecedor_id' => $fornecedor_id])
                ->with('success', 'Veículos importados com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao importar veículos: ' . $e->getMessage());
            return redirect()->route('veiculo.index', ['fornecedor_id' => $fornecedor_id])
                ->with('error', 'Erro ao importar veículos: ' . $e->getMessage());
        }
    }
}