<?php

use App\Http\Controllers\Admin\ReportExportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => session()->has('api_token')
    ? redirect()->route('dashboard')
    : redirect()->route('login'));

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware('api.auth')->group(function () {
    Route::view('/dashboard', 'dashboard.index')->middleware('permission:dashboard.view')->name('dashboard');

    Route::middleware('permission:users.view')->group(function () {
        Route::view('/usuarios', 'usuarios.index')->name('usuarios.index');
    });

    Route::middleware('permission:roles.view')->group(function () {
        Route::view('/roles', 'roles.index')->name('roles.index');
    });

    Route::middleware('permission:clients.view')->group(function () {
        Route::view('/clientes', 'clientes.index')->name('clientes.index');
    });
    Route::middleware('permission:drivers.view')->group(function () {
        Route::view('/conductores', 'conductores.index')->name('conductores.index');
    });
    Route::middleware('permission:vehicles.view')->group(function () {
        Route::view('/vehiculos', 'vehiculos.index')->name('vehiculos.index');
    });
    Route::middleware('permission:packages.view')->group(function () {
        Route::view('/envios', 'envios.index')->name('envios.index');
        Route::get('/envios/registrar', fn () => redirect()->route('envios.index'))->name('envios.registrar');
        Route::view('/estados', 'estados.index')->middleware('permission:package_statuses.view')->name('estados.index');
    });
    Route::middleware('permission:routes.view')->group(function () {
        Route::view('/rutas', 'rutas.index')->name('rutas.index');
    });
    Route::middleware('permission:assignments.view')->group(function () {
        Route::view('/asignaciones', 'rutas.asignar')->name('asignaciones.index');
    });
    Route::middleware('permission:reports.view')->group(function () {
        Route::view('/reportes', 'reportes.index')->name('reportes.index');
        Route::get('/reportes/export/{format}', ReportExportController::class)->middleware('permission:reports.export')->name('reportes.export');
    });
    Route::middleware('permission:settings.view')->group(function () {
        Route::get('/configuracion', [SettingsController::class, 'show'])->name('configuracion.index');
        Route::put('/configuracion/perfil', [SettingsController::class, 'updateProfile'])->name('configuracion.profile');
        Route::put('/configuracion/sistema', [SettingsController::class, 'updateSystem'])->name('configuracion.system');
        Route::put('/configuracion/notificaciones', [SettingsController::class, 'updateNotifications'])->name('configuracion.notifications');
    });
});
