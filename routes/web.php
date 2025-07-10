<?php

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
});

require __DIR__ . '/auth.php';
