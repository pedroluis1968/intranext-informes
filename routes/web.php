<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Desktop;
use App\Http\Livewire\SolicitudRegistro;
use App\Http\Livewire\Modelo347;
use Illuminate\Support\Facades\DB;

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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('desktop');
});
Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/registrar-solicitud', SolicitudRegistro::class)->name('registro-publico');
Route::get('/users-test', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/desktop', Desktop::class)->name('desktop');
});

Route::get('/modelo-347', Modelo347::class)->name('modelo-347');

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->withHeaders([
        'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
    ]);
})->name('logout');

