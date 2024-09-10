<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Fornecedor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Compartilhar a lista de fornecedores com todas as visões
        view()->composer('*', function ($view) {
            $fornecedores = Cache::remember('fornecedores_list', 5, function () {
                return Fornecedor::all();
            });
            $view->with('fornecedores', $fornecedores);
        });
    }
}
