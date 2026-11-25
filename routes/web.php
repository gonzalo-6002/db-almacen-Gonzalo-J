<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductosController;
use App\Livewire\Pages\Productos\Listado;

Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'pages::auth.login')
        ->name('login');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/productos', 'pages::productos.listados')->name('productos.index');
    Route::livewire('/movimientos', 'pages::movimientos.listados')->name('movimientos.index');
    Route::livewire('/proveedores', 'pages::proveedores.listados')->name('proveedores.index');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
