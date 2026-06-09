<?php

use Illuminate\Support\Facades\Route;
Route::get('/quiz',    fn() => view('quiz.index'))->name('quiz');
Route::get('/casas',   fn() => view('casas.index'))->name('casas');
Route::get('/dominios',fn() => view('dominios'))->name('dominios');
Route::get('/recorrido',fn() => view('recorrido'))->name('recorrido');
Route::get('/welcome',fn() => view('welcome'))->name('welcome');
Route::get('/', function () {
    return view('welcome');
});
