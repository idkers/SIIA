<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CasaController;
use App\Http\Controllers\DominioController;
use App\Http\Controllers\ResultadoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Quiz vocacional
|--------------------------------------------------------------------------
*/

Route::get('/quiz', function () {
    return view('quiz.index');
})
    ->middleware(['auth', 'quiz.no.realizado'])
    ->name('quiz');

Route::post('/resultados', [ResultadoController::class, 'guardar'])
    ->middleware('auth')
    ->name('resultados.guardar');

/*
|--------------------------------------------------------------------------
| Casas y dominios
|--------------------------------------------------------------------------
*/

Route::get('/casas', [CasaController::class, 'index'])
    ->name('casas');

Route::get('/dominios', [DominioController::class, 'index'])
    ->name('dominios');

/*
|--------------------------------------------------------------------------
| Recorrido virtual
|--------------------------------------------------------------------------
*/

Route::get('/recorrido', function () {
    return view('recorrido');
})->name('recorrido');

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
|
| Estas rutas solamente pueden ser utilizadas por personas que todavía
| no han iniciado sesión.
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/ingresar', [AuthController::class, 'mostrarIngreso'])
        ->name('ingresar');

    Route::post('/ingresar', [AuthController::class, 'ingresar'])
        ->name('ingresar.post');

    Route::get('/registrar', [AuthController::class, 'mostrarRegistro'])
        ->name('registrar');

    Route::post('/registrar', [AuthController::class, 'registrar'])
        ->name('registrar.post');
});

/*
|--------------------------------------------------------------------------
| Cierre de sesión
|--------------------------------------------------------------------------
*/

Route::post('/salir', [AuthController::class, 'salir'])
    ->middleware('auth')
    ->name('salir');

/*
|--------------------------------------------------------------------------
| Administración
|--------------------------------------------------------------------------
|
| Se requiere una sesión iniciada. El controlador también verifica que
| el usuario tenga el rol de administrador.
|
*/

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth')
    ->name('admin');