<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <title>@yield('title');</title>

        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.1/dist/tailwind.min.css" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">

    </head>
    <body class="bg-gray-100 text-gray-900">
        <header class="bg-white shadow-md">
            <nav class="container mx-auto px-4 py-3 flex items-center justify-between">                
                <a href="/fornecedor" class="text-2xl font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-300">
                    Fornecedores
                </a>
                @foreach ($fornecedores as $fornecedor)
                    <a href="{{ url($fornecedor->id . '/veiculo')}}" class="text-2xl font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-300">
                        {{ $fornecedor->nome }}
                    </a>
                @endforeach
                <!--<a href="/veiculo" class="text-2xl font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-300">
                    Veículos
                </a>-->
            </nav>
        </header>
    
        @if(session('success'))
            <div class="fixed top-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif
    
        @if($errors->any())
            <div class="fixed top-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <main class="container mx-auto px-4 py-6">
            @yield('content')
        </main>
    </body>
</html>