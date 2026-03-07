@extends('layouts.app')

@section('title', 'Dashboard - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
<style>

        /* Form Layout */
        .form-layout { display: grid; grid-template-columns: 1fr 320px; gap: var(--spacing-6); }
        .form-main { display: flex; flex-direction: column; gap: var(--spacing-5); }
        .form-sidebar { display: flex; flex-direction: column; gap: var(--spacing-5); }

        /* Form Card */
        .form-card { background-color: var(--bg-card); border-radius: var(--border-radius); padding: var(--spacing-6); }
        .form-card-header { display: flex; align-items: center; gap: var(--spacing-3); margin-bottom: var(--spacing-5); }
        .form-card-icon { width: 36px; height: 36px; border-radius: var(--border-radius-sm); display: flex; align-items: center; justify-content: center; }
        .form-card-icon.blue { background-color: var(--color-info-light); color: var(--color-info); }
        .form-card-icon.yellow { background-color: var(--color-warning-light); color: var(--color-warning); }
        .form-card-icon.green { background-color: var(--color-success-light); color: var(--color-success); }
        .form-card-title { font-size: var(--font-size-base); font-weight: 600; color: var(--text-primary); }
        .form-card-subtitle { font-size: var(--font-size-xs); color: var(--text-secondary); }

        /* Form Group */
        .form-group { margin-bottom: var(--spacing-4); }
        .form-group:last-child { margin-bottom: 0; }
        .form-label { display: block; font-size: var(--font-size-sm); font-weight: 500; color: var(--text-primary); margin-bottom: var(--spacing-2); }
        .form-label .optional { color: var(--text-muted); font-weight: 400; }

        /* Form Row */
        .form-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--spacing-4); }

        /* Estado Options */
        .estado-options { display: flex; flex-direction: column; gap: var(--spacing-2); }
        .estado-option { display: flex; align-items: center; gap: var(--spacing-3); padding: var(--spacing-3) var(--spacing-4); border: 1px solid var(--border-color); border-radius: var(--border-radius-sm); background-color: var(--bg-card); cursor: pointer; transition: all 0.2s; }
        .estado-option:hover { border-color: var(--color-primary); }
        .estado-option.active { background-color: var(--color-success-light); border-color: var(--color-success); }
        .estado-option.active .estado-text { color: var(--color-success); font-weight: 500; }
        .estado-dot { width: 10px; height: 10px; border-radius: 50%; }
        .estado-dot.pendiente { background-color: #9ca3af; }
        .estado-dot.transito { background-color: #f59e0b; }
        .estado-dot.entregado { background-color: #22c55e; }
        .estado-dot.retrasado { background-color: #ef4444; }
        .estado-dot.cancelado { background-color: #6b7280; }
        .estado-text { font-size: var(--font-size-sm); color: var(--text-secondary); }

        /* Summary Card */
        .summary-card { background-color: var(--sidebar-bg); border-radius: var(--border-radius); padding: var(--spacing-5); color: white; }
        .summary-title { font-size: var(--font-size-base); font-weight: 600; margin-bottom: var(--spacing-4); }
        .summary-list { display: flex; flex-direction: column; gap: var(--spacing-3); }
        .summary-item { display: flex; justify-content: space-between; align-items: center; font-size: var(--font-size-sm); }
        .summary-label { color: rgba(255,255,255,0.7); }
        .summary-value { display: flex; align-items: center; gap: var(--spacing-2); }
        .summary-status { color: rgba(255,255,255,0.7); }
        .summary-status.ok { color: #22c55e; }

        /* Back button */
        .back-btn { display: inline-flex; align-items: center; gap: var(--spacing-2); color: var(--text-secondary); font-size: var(--font-size-sm); margin-bottom: var(--spacing-4); }
        .back-btn:hover { color: var(--text-primary); }

        @media (max-width: 992px) {
            .form-layout { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
        }
</style>
<div class="content-area">
                <a href="{{ route('envios.index') }}" class="back-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Volver a envíos
                </a>

                <!-- Page Header -->
                <div class="page-header" style="margin-bottom: var(--spacing-6);">
                    <h2 class="page-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        Registrar Envío
                    </h2>
                    <p class="page-subtitle">Completa todos los campos requeridos del paquete</p>
                </div>

                <!-- Form Layout -->
                <div class="form-layout">
                    <!-- Main Form -->
                    <div class="form-main">
                        <!-- Identificación -->
                        <div class="form-card">
                            <div class="form-card-header">
                                <div class="form-card-icon blue">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                </div>
                                <div>
                                    <div class="form-card-title">Identificación del envío</div>
                                    <div class="form-card-subtitle">Datos únicos del paquete</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    Cliente
                                </label>
                                <div class="form-select-wrapper">
                                    <select class="form-select">
                                        <option value="">Selecciona un cliente</option>
                                        <option value="1">Juan García López</option>
                                        <option value="2">María Martínez Ruiz</option>
                                        <option value="3">Carlos Hernández Torres</option>
                                    </select>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="form-select-arrow"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M4 9h16M4 15h16M10 3L8 21M16 3l-2 18"></path></svg>
                                    Código de tracking
                                </label>
                                <input type="text" class="form-input" value="TMS-2026-735" readonly style="background-color: var(--bg-main); color: var(--text-muted);">
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                    Descripción del paquete
                                </label>
                                <textarea class="form-input" rows="3" placeholder="Describe el contenido del paquete..."></textarea>
                            </div>
                        </div>

                        <!-- Dimensiones -->
                        <div class="form-card">
                            <div class="form-card-header">
                                <div class="form-card-icon yellow">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                </div>
                                <div>
                                    <div class="form-card-title">Dimensiones y tipo</div>
                                    <div class="form-card-subtitle">Características físicas del paquete</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Peso (kg)</label>
                                    <input type="number" class="form-input" placeholder="0.0" step="0.1">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Volumen (cm³)</label>
                                    <input type="number" class="form-input" placeholder="0" step="1">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tipo de paquete</label>
                                    <div class="form-select-wrapper">
                                        <select class="form-select">
                                            <option value="">Selecciona tipo</option>
                                            <option value="sobre">Sobre</option>
                                            <option value="caja">Caja</option>
                                            <option value="paquete">Paquete</option>
                                            <option value="pallet">Pallet</option>
                                        </select>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="form-select-arrow"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ruta -->
                        <div class="form-card">
                            <div class="form-card-header">
                                <div class="form-card-icon green">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                </div>
                                <div>
                                    <div class="form-card-title">Ruta del envío</div>
                                    <div class="form-card-subtitle">Origen y destino del paquete</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    Dirección origen <span class="optional">(direccion_origen)</span>
                                </label>
                                <input type="text" class="form-input" placeholder="Calle, número, colonia, ciudad, estado">
                            </div>
                            <div style="display: flex; justify-content: center; margin: var(--spacing-3) 0;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                                <span style="font-size: var(--font-size-sm); color: var(--color-primary); margin-left: var(--spacing-2);">Destino</span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    Dirección destino <span class="optional">(direccion_destino)</span>
                                </label>
                                <input type="text" class="form-input" placeholder="Calle, número, colonia, ciudad, estado">
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="form-sidebar">
                        <!-- Fechas -->
                        <div class="form-card">
                            <div class="form-card-header">
                                <div class="form-card-icon blue">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                </div>
                                <div class="form-card-title">Fechas</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    Fecha de registro
                                </label>
                                <input type="date" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">F. est. de entrega</label>
                                <input type="date" class="form-input">
                            </div>
                        </div>

                        <!-- Estado inicial -->
                        <div class="form-card">
                            <div class="form-card-header">
                                <div class="form-card-icon yellow">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>
                                </div>
                                <div class="form-card-title">Estado inicial</div>
                            </div>
                            <p style="font-size: var(--font-size-xs); color: var(--text-secondary); margin-bottom: var(--spacing-3);">Selecciona el estado del paquete</p>
                            <div class="estado-options">
                                <div class="estado-option">
                                    <div class="estado-dot pendiente"></div>
                                    <span class="estado-text">Pendiente</span>
                                </div>
                                <div class="estado-option active">
                                    <div class="estado-dot transito"></div>
                                    <span class="estado-text">En tránsito</span>
                                </div>
                                <div class="estado-option">
                                    <div class="estado-dot entregado"></div>
                                    <span class="estado-text">Entregado</span>
                                </div>
                                <div class="estado-option">
                                    <div class="estado-dot retrasado"></div>
                                    <span class="estado-text">Retrasado</span>
                                </div>
                                <div class="estado-option">
                                    <div class="estado-dot cancelado"></div>
                                    <span class="estado-text">Cancelado</span>
                                </div>
                            </div>
                        </div>

                        <!-- Resumen -->
                        <div class="summary-card">
                            <div class="summary-title">Resumen del formulario</div>
                            <div class="summary-list">
                                <div class="summary-item">
                                    <span class="summary-label">Cliente</span>
                                    <span class="summary-status">Pendiente</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Tracking</span>
                                    <span class="summary-status ok">✓ OK</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Descripción</span>
                                    <span class="summary-status">Pendiente</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Peso / Vol.</span>
                                    <span class="summary-status">Pendiente</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Tipo</span>
                                    <span class="summary-status">Pendiente</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Origen</span>
                                    <span class="summary-status">Pendiente</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Destino</span>
                                    <span class="summary-status">Pendiente</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Fechas</span>
                                    <span class="summary-status">Pendiente</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <button class="btn-primary" style="width: 100%; justify-content: center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            Registrar envío
                        </button>
                        <a href="envios.html" class="btn-secondary" style="width: 100%; text-align: center; display: block; padding: var(--spacing-3);">Cancelar</a>
                    </div>
                </div>
            </div>
            <script>
                        // Estado options
        const estadoOptions = document.querySelectorAll('.estado-option');
        estadoOptions.forEach(option => {
            option.addEventListener('click', function() {
                estadoOptions.forEach(o => o.classList.remove('active'));
                this.classList.add('active');
            });
        });
            </script>
            @endsection