<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('welcome');

Route::get('/quiz', fn () => view('quiz.index'))->name('quiz');

Route::get('/casas', fn () => view('casas.index'))->name('casas');

Route::get('/dominios', fn () => view('dominios'))->name('dominios');

Route::get('/recorrido', fn () => view('recorrido'))->name('recorrido');

Route::get('/ingresar', fn () => view('ingresar'))->name('ingresar');

Route::post('/ingresar', function () {
    return back()->with('success', 'Formulario enviado correctamente.');
})->name('ingresar.post');