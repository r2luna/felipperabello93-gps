<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Empresa;
use App\Http\Livewire\Gps;
use App\Http\Livewire\Ponto;
use App\Http\Livewire\Prestador;
use App\Http\Livewire\Usuario;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/empresa', Empresa::class)->name('empresa');
    Route::get('/prestador', Prestador::class)->name('prestador');
    Route::get('/usuario', Usuario::class)->name('usuario');
    Route::middleware(['role_or_permission:publish articles|super-admin'])->get('/ponto', Ponto::class)->name('ponto');
});

Route::get('/gps', Gps::class)->name('getGps');

require __DIR__.'/auth.php';
