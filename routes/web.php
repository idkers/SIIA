<?php

use App\Http\Controllers\CasaController;
use App\Http\Controllers\DominioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/quiz', function () {
    return view('quiz');
})->name('quiz');

Route::get('/casas', [CasaController::class, 'index'])
    ->name('casas');

Route::get('/dominios', [DominioController::class, 'index'])
    ->name('dominios');

Route::get('/recorrido', function () {
    return view('recorrido');
})->name('recorrido');

Route::get('/ingresar', function () {
    return view('ingresar');
})->name('ingresar');

Route::post('/ingresar', function (Request $request) {
    $credenciales = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $usuario = User::where('email', $credenciales['email'])->first();

    if (!$usuario || !Hash::check($credenciales['password'], $usuario->password)) {
        return back()
            ->withErrors([
                'email' => 'Las credenciales no son correctas.',
            ])
            ->onlyInput('email');
    }

    session([
        'usuario_id' => $usuario->id,
        'usuario_nombre' => $usuario->name,
        'usuario_rol' => $usuario->rol,
    ]);

    return redirect()->route('welcome');
})->name('ingresar.post');

Route::get('/registrar', function () {
    return view('registrar');
})->name('registrar');

Route::post('/registrar', function (Request $request) {
    $datos = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $usuario = User::create([
        'name' => $datos['name'],
        'email' => $datos['email'],
        'password' => $datos['password'],
        'rol' => 'usuario',
    ]);

    session([
        'usuario_id' => $usuario->id,
        'usuario_nombre' => $usuario->name,
        'usuario_rol' => $usuario->rol,
    ]);

    return redirect()->route('welcome');
})->name('registrar.post');

Route::get('/admin', function () {
    return view('admin');
})->name('admin');