@extends('layouts.main')
@php
    $fornecedor = $fornecedor ?? null; //para abrir com form de cadastrar
@endphp

@section('title', $fornecedor ? 'Editar Fornecedor':'Cadastrar Fornecedor')

@section('content')
<link rel='stylesheet' href='../css/form.css'>

<form action="{{ isset($fornecedor) ? route('fornecedor.update', $fornecedor->id) : route('fornecedor.store') }}" method="POST" class="space-y-4 p-4 max-w-lg mx-auto bg-white shadow-lg rounded-lg">
    @csrf
    @if(isset($fornecedor))
        @method('PUT') <!-- Utilize PUT para atualização -->
    @endif  

    <div>
        <label for="nome" class="block text-gray-700 font-medium">Nome:</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome', $fornecedor->nome ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
    </div>

    <div>
        <label for="url" class="block text-gray-700 font-medium">Url:</label>
        <input type="url" id="url" name="url" value="{{ old('url', $fornecedor->url ?? '') }}" required placeholder="https://example.com"  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
    </div>
   
    <div class="flex justify-between items-center">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            {{ isset($fornecedor) ? 'Atualizar' : 'Salvar' }}
        </button>
        <a href="/fornecedor" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring focus:ring-gray-500 focus:ring-opacity-50">Voltar</a>
    </div>
</form>

@endsection