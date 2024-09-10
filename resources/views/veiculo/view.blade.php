@extends('layouts.main')

@section('title', 'Visualizar Veículo')

@section('content')
<link rel='stylesheet' href='../css/form.css'>

<div class="p-4 max-w-2xl mx-auto bg-white shadow-lg rounded-lg">
    <!-- Código do Veículo -->
    <div class="mb-4">
        <label for="codigoVeiculo" class="block text-gray-700 font-medium">Código do Veículo:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->codigoVeiculo }}
        </div>
    </div>

    <!-- Marca -->
    <div class="mb-4">
        <label for="marca" class="block text-gray-700 font-medium">Marca:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->marca }}
        </div>
    </div>

    <!-- Modelo -->
    <div class="mb-4">
        <label for="modelo" class="block text-gray-700 font-medium">Modelo:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->modelo }}
        </div>
    </div>

    <!-- Ano -->
    <div class="mb-4">
        <label for="ano" class="block text-gray-700 font-medium">Ano:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->ano }}
        </div>
    </div>

    <!-- Versão -->
    <div class="mb-4">
        <label for="versao" class="block text-gray-700 font-medium">Versão:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->versao }}
        </div>
    </div>

    <!-- Cor -->
    <div class="mb-4">
        <label for="cor" class="block text-gray-700 font-medium">Cor:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->cor }}
        </div>
    </div>

    <!-- Quilometragem -->
    <div class="mb-4">
        <label for="km" class="block text-gray-700 font-medium">Quilometragem:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->km }} km
        </div>
    </div>

    <!-- Combustível -->
    <div class="mb-4">
        <label for="combustivel" class="block text-gray-700 font-medium">Combustível:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->combustivel }}
        </div>
    </div>

    <!-- Câmbio -->
    <div class="mb-4">
        <label for="cambio" class="block text-gray-700 font-medium">Câmbio:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->cambio }}
        </div>
    </div>

    <!-- Portas -->
    <div class="mb-4">
        <label for="portas" class="block text-gray-700 font-medium">Portas:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ $veiculo->portas }}
        </div>
    </div>

    <!-- Preço -->
    <div class="mb-4">
        <label for="preco" class="block text-gray-700 font-medium">Preço:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            R$ {{ number_format($veiculo->preco, 2, ',', '.') }}
        </div>
    </div>

    <!-- Data -->
    <div class="mb-4">
        <label for="date" class="block text-gray-700 font-medium">Data:</label>
        <div class="mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
            {{ \Carbon\Carbon::parse($veiculo->date)->format('d/m/Y H:i') }}
        </div>
    </div>

    <!-- Opcionais -->
    <div class="mb-4">
        <label for="opcionais" class="block text-gray-700 font-medium">Opcionais:</label>
        <select id="opcionais" name="opcionais[]" multiple disabled class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed">
            @foreach($veiculo->opcionais as $opcional)
                <option value="{{ $opcional->id }}">
                    {{ $opcional->descricao }}
                </option>
            @endforeach
        </select>
    </div>

    <a href="{{ url($fornecedor_id . '/veiculo') }}" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring focus:ring-gray-500 focus:ring-opacity-50">
        Voltar
    </a>
</div>

@endsection
