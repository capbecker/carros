<?php

namespace App\Http\Services;

use App\Models\Veiculo;
use App\Models\Opcional;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SimpleXMLElement;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class VeiculoService
{

    public function filterVeiculos($fornecedorId, $request)
    {
        $query = Veiculo::where('fornecedor_id', $fornecedorId);

        if ($request->has('marca') && $request->marca != '') {
            $query->where('marca', 'like', '%' . $request->marca . '%');
        }

        if ($request->has('modelo') && $request->modelo != '') {
            $query->where('modelo', 'like', '%' . $request->modelo . '%');
        }

        return $query->get();
    }

    public function importVeiculosFromXml($fornecedor_id, $file)
    {
        $xmlContent = file_get_contents($file);
        $xml = new SimpleXMLElement($xmlContent);

        foreach ($xml->veiculos->veiculo as $veiculoData) {
            $dateString =  $veiculoData->date?: $veiculoData->ultimaAtualizacao;
            $veiculo = Veiculo::updateOrCreate([                
                'fornecedor_id' => $fornecedor_id,    
                'codigoVeiculo' => (int) $veiculoData->codigoVeiculo?:$veiculoData->id,
                'marca' => (string) $veiculoData->marca,
                'modelo' => (string) $veiculoData->modelo,
                'ano' => (int) $veiculoData->ano,
                'versao' => (string) $veiculoData->versao,
                'cor' => (string) $veiculoData->cor,
                'km' => (int) $veiculoData->km ?: $veiculoData->quilometragem,
                'combustivel' => !empty($veiculoData->combustivel) ? (string) $veiculoData->combustivel : ($veiculoData->tipoCombustivel ?? null),
                'cambio' => !empty($veiculoData->cambio) ?(string) $veiculoData->cambio : null,
                'portas' => (int) $veiculoData->portas,
                'preco' => (float) $veiculoData->preco ?: $veiculoData->precoVenda,
                'date' => $this->parseDate($dateString)
            ]);
            foreach ($veiculoData->opcionais->opcional as $opcionalData) {
                Opcional::updateOrCreate([
                    'veiculo_id' => (int) $veiculo->id,
                    'descricao' => (string) $opcionalData
                ]);                
            }
        }
    }

    public function importVeiculosFromJson($fornecedor_id,$file)
    {
        $jsonContent = file_get_contents($file);
        // Decodifica o conteúdo JSON para um array PHP
        $data = json_decode($jsonContent);

        // Verifica se a decodificação foi bem-sucedida
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erro ao decodificar JSON: " . json_last_error_msg() . $data);
        }

        foreach ($data->veiculos as $veiculoData) {
            $dateString = $veiculoData->date ?? $veiculoData->ultimaAtualizacao;
            
            // Cria o veículo
            $veiculo = Veiculo::create([
                'fornecedor_id' => $fornecedor_id,    
                'codigoVeiculo' => (int) ($veiculoData->codigoVeiculo ?? $veiculoData->id),
                'marca' => (string) $veiculoData->marca,
                'modelo' => (string) $veiculoData->modelo,
                'ano' => (int) $veiculoData->ano,
                'versao' => (string) $veiculoData->versao,
                'cor' => (string) $veiculoData->cor,
                'km' => (int) ($veiculoData->km ?? $veiculoData->quilometragem),
                'combustivel' => !empty($veiculoData->combustivel) ? (string) $veiculoData->combustivel : ($veiculoData->tipoCombustivel ?? null),
                'cambio' => !empty($veiculoData->cambio) ? (string) $veiculoData->cambio : null,
                'portas' => (int) $veiculoData->portas,
                'preco' => (float) ($veiculoData->preco ?? $veiculoData->precoVenda),
                'date' => $this->parseDate($dateString)
            ]);

            foreach ($veiculoData->opcionais as $opcionalData) {
                Opcional::create([
                    'veiculo_id' => (int) $veiculo->id,
                    'descricao' => (string) $opcionalData
                ]);
            }
        }
    }

    /**
     * obtem um date a partir de uma string em diferentes formatos
     */
    private function parseDate($dateString) {
        if (empty($dateString)) {
            return null;
        }
        $formats = [
            'd/m/Y H:i',  
            'Y-m-d H:i:s', 
            'Y-m-d H:i',   
            'd/m/Y H:i:s', 
        ];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $dateString);
                if ($date !== false) {
                    return $date;
                }
            } catch (\Exception $e) {
                // Continue trying other formats
            }
        }    
        return null; 
    }

    private function eachVeiculo($veiculo, $parentNode) {
        Log::Error('Veiculo: ');
        $veiculoNode = $parentNode->addChild('veiculo');        

        $veiculoNode->addChild('codigoVeiculo', $veiculo->codigoVeiculo);
        $veiculoNode->addChild('modelo', $veiculo->modelo);
        $veiculoNode->addChild('marca', $veiculo->marca);
        $veiculoNode->addChild('ano', $veiculo->ano);
        $veiculoNode->addChild('versao', $veiculo->versao);
        $veiculoNode->addChild('cor', $veiculo->cor);
        $veiculoNode->addChild('km', $veiculo->km);
        $veiculoNode->addChild('combustivel', $veiculo->combustivel);
        $veiculoNode->addChild('cambio', $veiculo->cambio);
        $veiculoNode->addChild('portas', $veiculo->portas);
        $veiculoNode->addChild('preco', $veiculo->preco);
        $veiculoNode->addChild('date', $veiculo->date);

        $opcionais = $veiculoNode->addChild('opcionais');
        foreach ($veiculo->opcionais as $opcional) {
            $opcionais->addChild('opcional', $opcional->descricao);
        }
    }

    public function exportSingleVeiculo($fornecedor_id, $id)
    {        
        $veiculo = Veiculo::where('fornecedor_id', $fornecedor_id)->where('id', $id)->firstOrFail();                 
        $xml = new SimpleXMLElement('<estoque/>');           
        $this->eachVeiculo($veiculo, $xml);
        $xmlString = $xml->asXML();
        return Response::make($xmlString, 200, [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="veiculo_' . $veiculo->id . '.xml"'
        ]);
    }

    public function exportVeiculo($fornecedor_id)
    {
        $fornecedor = Fornecedor::with('veiculos')->findOrFail($fornecedor_id);
        $xml = new SimpleXMLElement('<estoque/>');  
        foreach($fornecedor->veiculos as $veiculo) {
            $this->eachVeiculo($veiculo, $xml);
        } 
        $this->eachVeiculo($veiculo, $xml);        
        $xmlString = $xml->asXML();
        return Response::make($xmlString, 200, [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="fornecedor_' . $fornecedor->nome . '.xml"'
        ]);
    }

    
}
