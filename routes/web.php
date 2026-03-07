<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/usuarios', function () {
    return view('usuarios.index');
})->name('usuarios.index');

Route::get('/clientes', function () {
    return view('clientes.index');
})->name('clientes.index');

Route::get('conductores', function () {
    return view('conductores.index');
})->name('conductores.index');

Route::get('/vehiculos', function () {
    return view('vehiculos.index');
})->name('vehiculos.index');

Route::get('/envios', function () {
    return view('envios.index');
})->name('envios.index');

Route::get('/envios/registrar', function () {
    return view('envios.registrar');
})->name('envios.registrar');

Route::get('/estados', function () {
    return view('estados.index');
})->name('estados.index');

Route::get('/rutas', function () {
    return view('rutas.index');
})->name('rutas.index');

Route::get('/rutas-asignadas', function () {
    return view('rutas.asignar');
})->name('rutas.asignar');

Route::get('/roles', function () {
    return view('roles.index');
})->name('roles.index');

Route::get('/permisos', function () {
    return view('permisos.index');
})->name('permisos.index');

Route::get('/configuracion', function () {
    return view('configuracion.index');
})->name('configuracion.index');

Route::get('/reportes', function () {
    return view('reportes.index');
})->name('reportes.index');

