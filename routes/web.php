<?php

use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\FornecedorController;

Route::get('/', function () {
    return view('home');
});

Route::middleware(['web'])->group(function () {   
});

//Fornecedor
Route::get('/fornecedor', [FornecedorController::class, 'index'])->name('fornecedor.index');

Route::get('/fornecedor/create', [FornecedorController::class, 'create']);
Route::post('/fornecedor', [FornecedorController::class, 'store'])->name('fornecedor.store');

Route::get('/fornecedor/{id}', [FornecedorController::class, 'edit'])->name('fornecedor.edit');
Route::put('/fornecedor/{id}', [FornecedorController::class, 'update'])->name('fornecedor.update');

Route::delete('/fornecedor/{id}', [FornecedorController::class, 'destroy'])->name('fornecedor.destroy');


//Veículo

//Route::get('{fornecedor_id}/veiculo', [VeiculoController::class, 'index'])->name('veiculo.index');
//Route::get('{fornecedor_id}/veiculo/filter', [VeiculoController::class, 'filter'])->name('veiculo.filter');

Route::get('{fornecedor_id}/veiculo', [VeiculoController::class, 'index'])->name('veiculo.index');


Route::get('{fornecedor_id}/veiculo/{id}', [VeiculoController::class, 'view'])->name('veiculo.view');
Route::delete('{fornecedor_id}/veiculo/{id}', [VeiculoController::class, 'destroy'])->name('veiculo.destroy');

Route::get('{fornecedor_id}/veiculo/exportSingle/{id}', [VeiculoController::class, 'exportSingleVeiculo'])->name('veiculo.exportSingleVeiculo');
//Route::get('{fornecedor_id}/veiculo/exportFornecedorVeiculo/{id}', [VeiculoController::class, 'exportFornecedorVeiculo'])->name('veiculo.exportFornecedorVeiculo');
Route::get('{fornecedor_id}/veiculo/exportFornecedorVeiculo', [VeiculoController::class, 'exportFornecedorVeiculo'])->name('veiculo.exportFornecedorVeiculo');

Route::get('{fornecedor_id}/veiculo/importVeiculo', [VeiculoController::class, 'formImport'])->name('veiculo.formImport');
//Route::get('{fornecedor_id}/veiculo/importVeiculo/{id}', [VeiculoController::class, 'formImport'])->name('veiculo.formImport');
Route::post('{fornecedor_id}/veiculo/importVeiculo', [VeiculoController::class, 'import'])->name('veiculo.import');