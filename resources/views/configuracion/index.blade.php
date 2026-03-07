@extends('layouts.app')

@section('title', 'Configuración - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-top">
                <div>
                    <h2 class="page-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="6" x2="12" y2="12"></line>
                            <line x1="12" y1="12" x2="16" y2="14"></line>
                        </svg>
                        Configuración
                    </h2>
                    <p class="page-subtitle">Ajustes generales del sistema</p>
                </div>
                <div class="search-box">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Buscar opción...">
                </div>
            </div>
        </div>

        <!-- Settings grid -->
        <div class="cards-grid">
            <div class="feature-card">
                <div class="feature-card-icon blue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83"></path>
                    </svg>
                </div>
                <h3 class="feature-card-title">Perfil</h3>
                <p class="feature-card-desc">Información personal y de contacto</p>
                <a href="#" class="feature-card-link blue">
                    Ir a Perfil
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
            <div class="feature-card">
                <div class="feature-card-icon green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2a10 10 0 0 0-10 10"></path>
                        <path d="M2 12h20"></path>
                    </svg>
                </div>
                <h3 class="feature-card-title">Sistema</h3>
                <p class="feature-card-desc">Parámetros generales y comportamiento</p>
                <a href="#" class="feature-card-link green">
                    Ajustes del Sistema
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
            <div class="feature-card">
                <div class="feature-card-icon yellow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 8v4l3 3"></path>
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                </div>
                <h3 class="feature-card-title">Notificaciones</h3>
                <p class="feature-card-desc">Configura alertas y correos</p>
                <a href="#" class="feature-card-link yellow">
                    Configurar Notificaciones
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endsection