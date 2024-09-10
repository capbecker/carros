<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'codigoVeiculo' => 'required|integer|unique:veiculos,codigoVeiculo,' . $this->id,
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'ano' => 'nullable|integer|min:1950|max:' . date('Y'),
            'versao' => 'nullable|string|max:50',
            'cor' => 'nullable|string|max:30',
            'km' => 'nullable|integer|min:0',
            'combustivel' => 'nullable|in:Gasolina,Álcool,Diesel,Elétrico,Híbrido,Flex',
            'cambio' => 'nullable|in:Manual,Automático',
            'portas' => 'nullable|integer|in:2,4',
            'preco' => 'nullable|numeric|min:0',
            'date' => 'nullable|date_format:Y-m-d\TH:i',
        ];
    }
}
