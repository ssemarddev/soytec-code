<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientAuthController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});

/** Ruta del login */
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'authenticate']);

/** Ruta de ejemplo */
Route::get('/example', function () {
    return view('example', ['example' => env('EXAMPLE_VAR')]);
});

Route::get('/auth/{driver}/login', [ClientAuthController::class, 'socialite']);

Route::get('/auth/{driver}/callback', [ClientAuthController::class, 'sign']);

Route::get('/doc/api', function () {
    return view('doc/api');
});
