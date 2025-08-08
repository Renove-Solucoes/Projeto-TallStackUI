<?php

use App\Http\Controllers\PedidosVendaPdfController;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users\Index;

Route::view('/', 'welcome')->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/users', Index::class)->name('users.index');

    Route::get('/user/profile', Profile::class)->name('user.profile');

    Route::get('/clientes', App\Livewire\Clientes\Index::class)->name('clientes.index');

    Route::get('/tags', App\Livewire\Tags\Index::class)->name('tags.index');

    Route::get('/categorias', App\Livewire\Categorias\Index::class)->name('categorias.index');

    Route::get('/produtos', App\Livewire\Produtos\Index::class)->name('produtos.index');

    Route::get('/tabelasprecos', App\Livewire\TabelasPrecos\Index::class)->name('tabelasprecos.index');

    Route::get('/pedidosvendas', App\Livewire\PedidosVendas\Index::class)->name('pedidosvendas.index');
    Route::get('/pedidosvendas/create', App\Livewire\PedidosVendas\Create::class)->name('pedidosvendas.create');
    Route::get('/pedidosvendas/{pedidosVenda}/edit', App\Livewire\PedidosVendas\Update::class)->name('pedidosvendas.edit');
    Route::get('/pedidos-vendas/{pedidosVenda}/pdf', [PedidosVendaPdfController::class, 'generatePdf'])
        ->name('pedidosvendas.generate-pdf');
});

require __DIR__ . '/auth.php';
