@extends('layouts.main')

@section('title', 'Listagem Fornecedores')
@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Listagem de Fornecedores</h1>
    
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
            <tr>
                <th class="py-3 px-4 border-b">Nome</th>
                <th class="py-3 px-4 border-b">Link</th>       
                <th class="py-3 px-4 border-b">Ações</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm">
            @foreach ($fornecedores as $fornecedor)
                <tr class="hover:bg-gray-100 border-b">
                    <td class="py-3 px-4">{{ $fornecedor->nome }}</td>
                    <td class="py-3 px-4">{{ $fornecedor->url }}</td>                    
                    <td class="py-3 px-4 flex space-x-2">
                        <a href="{{ route('fornecedor.edit', $fornecedor->id) }}" class="text-blue-500 hover:underline">Editar</a>
                        <a href="{{ route('veiculo.exportFornecedorVeiculo', ['fornecedor_id' => $fornecedor->id, 'id' => $fornecedor->id]) }}" class="text-blue-500 hover:underline">Exportar</a>                        
                        <form action="{{ route('fornecedor.destroy', ['id' => $fornecedor->id]) }}" method="post">
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
        <a class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" href="/fornecedor/create">Cadastrar</a>        
    </div>
</div>
@endsection



