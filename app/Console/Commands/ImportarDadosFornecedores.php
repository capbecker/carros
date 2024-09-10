<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Fornecedor;
use App\Models\Veiculo;
use App\Models\Opcional;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ImportarDadosFornecedores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:importar-dados-fornecedores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {        
        $fornecedores = Fornecedor::all();//cache('fornecedores_list');
        
        if ($fornecedores) {
            Log::info(count($fornecedores));
            foreach ($fornecedores as $fornecedor) {
                // Fazer a requisição para a URL do fornecedor
                $response = Http::get($fornecedor->url);

                if ($response->successful()) {
                    $content = $response->body();
                    
                    // Tentar detectar se o conteúdo é JSON ou XML
                    $dados = json_decode($content, true); // Decodifica como array associativo
    
                    if (json_last_error() === JSON_ERROR_NONE) {                        
                        $this->processDataJson($fornecedor->id, $dados);
                    } else {
                        $xml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
                        if ($xml !== false) {
                            $this->processDataXml($fornecedor->id, $xml);
                        }
                    }
                } else {
                    $this->error("Falha ao importar dados do fornecedor: {$fornecedor->nome}");
                }
            }
        } else {
            $this->info('Nenhum fornecedor encontrado para importar dados.');
        }
    }
    
    protected function processDataJson($fornecedor_id, array $dados)
    {                   
        foreach ($dados['veiculos'] as $veiculoData) {            
            $dateString = $veiculoData['date'] ?? $veiculoData['ultimaAtualizacao'];
            $veiculo = Veiculo::updateOrCreate(
                ['codigoVeiculo' => (int) ($veiculoData['codigoVeiculo'] ?? $veiculoData['id'])],
                [
                    'fornecedor_id' => $fornecedor_id,
                    'marca' => (string) $veiculoData['marca'],
                    'modelo' => (string) $veiculoData['modelo'],
                    'ano' => (int) $veiculoData['ano'],
                    'versao' => (string) $veiculoData['versao'],
                    'cor' => (string) $veiculoData['cor'],
                    'km' => (int) ($veiculoData['km'] ?? $veiculoData['quilometragem']),
                    'combustivel' => (string) ($veiculoData['combustivel'] ?? $veiculoData['tipoCombustivel']),
                    'cambio' => (string) $veiculoData['cambio'],
                    'portas' => (int) $veiculoData['portas'],
                    'preco' => (float) ($veiculoData['preco'] ?? $veiculoData['precoVenda']),
                    'date' => $this->parseDate($dateString),
                ]
            );
            if (isset($veiculoData['opcionais'])) {
                foreach ($veiculoData['opcionais'] as $opcionalData) {
                    Opcional::updateOrCreate(
                        ['veiculo_id' => $veiculo->id, 'descricao' => (string) $opcionalData],
                        ['descricao' => (string) $opcionalData]
                    );
                }
            }
        }
    }


    protected function parseDate($dateString) {
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

    protected function processDataXml($fornecedor_id, $xml)
    {   
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
                'combustivel' => !empty($veiculoData->combustivel) ? (string) $veiculoData->combustivel : ($veiculoData->tipocombustivel ?? null),
                'cambio' => !empty($veiculoData->cambio) ?(string) $veiculoData->cambio : null,
                'portas' => (int) $veiculoData->portas,
                'preco' => (float) $veiculoData->preco ?: $veiculoData->precoVenda,
                'date' => $this->parseDate($dateString)
            ]);
            if (isset($veiculoData->opcionais)) {
                foreach ($veiculoData->opcionais->opcional as $opcionalData) {
                    Opcional::updateOrCreate([
                        'veiculo_id' => (int) $veiculo->id,
                        'descricao' => (string) $opcionalData
                    ]);                
                }
            }
        } 
    }


     /*protected function findLevelVeiculo(array $dados) {
        $camadas = [];
        $dadosAtual = $dados;
        $camadas[] = array_keys($dados)[0];
        if (array_keys($dados)[0]!=='veiculos') {    
            // Função recursiva para identificar camadas
            $this->explorarCamadas($dadosAtual, $camadas);
        }
    
        return implode('.', $camadas);
    }
    
    protected function explorarCamadas($dados, &$camadas) {
        if (is_array($dados)) {
            $chaves = array_keys($dados);                     
            foreach ($chaves as $chave) {
                $camadas[] = $chave;
                if ($chaves[0]=='veiculos') {
                    return;
                }   
                if (isset($dados[$chave]) && is_array($dados[$chave])) {
                    $this->explorarCamadas($dados[$chave], $camadas);
                    break; 
                }
            }
        }
    }*/
}