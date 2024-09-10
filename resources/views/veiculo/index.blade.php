@extends('layouts.main')

@section('title', 'Listagem Veículos')
@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Listagem de Veículos</h1>    

    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
            <tr>
                <th class="py-3 px-4 border-b">Código</th>
                <th class="py-3 px-4 border-b">Marca</th>
                <th class="py-3 px-4 border-b">Modelo</th>
                <th class="py-3 px-4 border-b">Ano</th>
                <th class="py-3 px-4 border-b">Versão</th>
                <th class="py-3 px-4 border-b">Cor</th>
                <th class="py-3 px-4 border-b">Quilometragem</th>
                <th class="py-3 px-4 border-b">Tipo de Combustível</th>
                <th class="py-3 px-4 border-b">Câmbio</th>
                <th class="py-3 px-4 border-b">Portas</th>
                <th class="py-3 px-4 border-b">Preço de Venda</th>
                <th class="py-3 px-4 border-b">Última Atualização</th>
                <th class="py-3 px-4 border-b">Ações</th>
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

    <div class="mt-6">           
        <a href="{{ route('veiculo.formImport', ['fornecedor_id' => $fornecedor_id, 'id' => $fornecedor_id]) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Importar</a>        
        <a href="{{ route('veiculo.exportFornecedorVeiculo', ['fornecedor_id' => $fornecedor_id, 'id' => $fornecedor_id]) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Exportar</a>        
    </div>
</div>
@endsection



