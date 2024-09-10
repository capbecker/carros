@extends('layouts.main')

@section('title', 'Listagem de Veículos')

@section('content')
<style type="text/css">
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem 0;
    list-style: none;
}

.pagination .page-item {
    margin: 0;
}

.pagination .page-link {
    display: inline-block;
    padding: 0.5rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    text-decoration: none;
    color: #4a5568;
    background-color: #ffffff;
    font-size: 0.875rem; /* Ajuste do tamanho da fonte */
    line-height: 1.5; /* Alinhamento vertical */
    transition: background-color 0.3s, border-color 0.3s;
    text-align: center; /* Centraliza o texto dentro do botão */
    vertical-align: middle; /* Alinha verticalmente com o texto */
}

.pagination .page-link:hover {
    background-color: #e2e8f0;
    border-color: #cbd5e0;
}

.pagination .page-item.active .page-link {
    background-color: #3182ce;
    color: white;
    border-color: #3182ce;
}

.pagination .page-item.disabled .page-link {
    color: #e2e8f0;
    border-color: #e2e8f0;
    pointer-events: none;
}

.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    border-radius: 0.375rem;
}

.pagination .page-item:not(.disabled) .page-link {
    cursor: pointer;
}

.pagination .page-item svg {
    width: 1rem;
    height: 1rem;
    vertical-align: middle; /* Alinha verticalmente com o texto */
}
</style>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Listagem de Veículos</h1>

    <!-- Ordenação -->
    <div class="mb-4 flex justify-between items-center">
        <form method="GET" action="{{ route('veiculo.index', $fornecedor_id) }}" class="flex items-center space-x-2">
            <label for="sort_by" class="text-gray-700">Ordenar por:</label>
            <select id="sort_by" name="sort_by" class="border border-gray-300 rounded-md p-2">
                <option value="codigoVeiculo" {{ request('sort_by') == 'codigoVeiculo' ? 'selected' : '' }}>Código</option>
                <option value="marca" {{ request('sort_by') == 'marca' ? 'selected' : '' }}>Marca</option>
                <option value="modelo" {{ request('sort_by') == 'modelo' ? 'selected' : '' }}>Modelo</option>
                <option value="ano" {{ request('sort_by') == 'ano' ? 'selected' : '' }}>Ano</option>
                <option value="preco" {{ request('sort_by') == 'preco' ? 'selected' : '' }}>Preço</option>
                <!-- Adicione mais opções conforme necessário -->
            </select>
            <select name="sort_direction" class="border border-gray-300 rounded-md p-2">
                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descendente</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ordenar</button>
        </form>
    </div>

    <!-- Tabela -->
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
            <tr>
                <th class="py-3 px-4 border-b">
                    <a href="{{ route('veiculo.index', array_merge(request()->except(['page']), ['fornecedor_id' => $fornecedor_id, 'sort_by' => 'codigoVeiculo', 'sort_direction' => request('sort_direction', 'asc') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                        Código
                        @if(request('sort_by') == 'codigoVeiculo')
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        @endif
                    </a>
                </th>
                <th class="py-3 px-4 border-b">
                    <a href="{{ route('veiculo.index', array_merge(request()->except(['page']), ['fornecedor_id' => $fornecedor_id, 'sort_by' => 'marca', 'sort_direction' => request('sort_direction', 'asc') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                        Marca
                        @if(request('sort_by') == 'marca')
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        @endif
                    </a>
                </th>
                <!-- Repita para outras colunas -->
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm">
            @foreach ($veiculos as $veiculo)
                <tr class="hover:bg-gray-100 border-b">
                    <td class="py-3 px-4">{{ $veiculo->codigoVeiculo }}</td>
                    <td class="py-3 px-4">{{ $veiculo->marca }}</td>
                    <td class="py-3 px-4">{{ $veiculo->modelo }}</td>
                    <td class="py-3 px-4">{{ $veiculo->ano }}</td>
                    <td class="py-3 px-4">{{ $veiculo->versao }}</td>
                    <td class="py-3 px-4">{{ $veiculo->cor }}</td>
                    <td class="py-3 px-4">{{ $veiculo->km }}</td>
                    <td class="py-3 px-4">{{ $veiculo->combustivel }}</td>
                    <td class="py-3 px-4">{{ $veiculo->cambio }}</td>
                    <td class="py-3 px-4">{{ $veiculo->portas }}</td>
                    <td class="py-3 px-4">{{ $veiculo->preco }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($veiculo->date)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 flex space-x-2">
                        <a href="{{ route('veiculo.view', ['fornecedor_id' => $fornecedor_id, 'id' => $veiculo->id]) }}" class="text-blue-500 hover:underline">Vizualizar</a>
                        <a href="{{ route('veiculo.exportSingleVeiculo', ['fornecedor_id' => $fornecedor_id, 'id' => $veiculo->id]) }}" class="text-blue-500 hover:underline">Exportar</a>
                        <form action="{{ route('veiculo.destroy', ['fornecedor_id' => $fornecedor_id, 'id' => $veiculo->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="mt-6">
        {{ $veiculos->links() }}
    </div>

    <div class="mt-6">
        <a href="{{ route('veiculo.formImport', ['fornecedor_id' => $fornecedor_id]) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Importar</a>
        <a href="{{ route('veiculo.exportFornecedorVeiculo', ['fornecedor_id' => $fornecedor_id]) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Exportar</a>
    </div>
@endsection
