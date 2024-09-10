<?php

return [

    'required' => 'O campo :attribute é obrigatório.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',
    'string' => 'O campo :attribute deve ser uma string.',
    'max' => [
        'string' => 'O campo :attribute não pode ter mais de :max caracteres.',
        'numeric' => 'O campo :attribute não pode ser maior que :max.',
    ],
    'min' => [
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'nullable' => 'O campo :attribute pode ser nulo.',
    'date_format' => 'O campo :attribute deve corresponder ao formato :format.',
    'in' => 'O campo :attribute deve ser um dos seguintes: :values.',
    'unique' => 'O campo :attribute já está em uso.',
    'numeric' => 'O campo :attribute deve ser um número.',
    'exists' => 'O campo :attribute selecionado é inválido.',
    
    // Adicione outras mensagens de validação conforme necessário
    // ...

    'attributes' => [
        'codigoVeiculo' => 'código do veículo',
        'marca' => 'marca',
        'modelo' => 'modelo',
        'ano' => 'ano',
        'versao' => 'versão',
        'cor' => 'cor',
        'km' => 'quilometragem',
        'combustivel' => 'combustível',
        'cambio' => 'câmbio',
        'portas' => 'portas',
        'preco' => 'preço',
        'date' => 'data',
    ],
];