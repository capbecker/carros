@extends('layouts.main')

@section('title', 'Listagem Veículos')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Importar de Veículos</h1>
    <form action="{{ route('veiculo.import', ['fornecedor_id' => $fornecedor_id]) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="file" class="block text-gray-700 text-sm font-medium mb-2">Selecione um arquivo XML:</label>
            <input type="file" id="file" name="file" accept=".xml, .json" required class="form-input block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">            
            
            <select name="file_type" required>
                <option value="xml">XML</option>
                <option value="json">JSON</option>
            </select>    
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Importar
        </button>
        <a href="{{ url($fornecedor_id . '/veiculo')}}" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring focus:ring-gray-500 focus:ring-opacity-50">Voltar</a>        
    </form>    
</div>   
@endsection


