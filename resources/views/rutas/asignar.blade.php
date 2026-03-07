@extends('layouts.app')

@section('title', 'Dashboard - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
    <style>

        /* Form Card Blue */
        .form-card-blue {
            background: linear-gradient(135deg, #1e3a4a 0%, #2d5a6e 100%);
            border-radius: var(--border-radius);
            padding: var(--spacing-6);
            color: white;
            margin-bottom: var(--spacing-6);
        }
        .form-card-blue-header {
            display: flex;
            align-items: center;
            gap: var(--spacing-3);
            margin-bottom: var(--spacing-5);
        }
        .form-card-blue-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-card-blue-title { font-size: var(--font-size-lg); font-weight: 600; }
        .form-card-blue-subtitle { font-size: var(--font-size-sm); color: rgba(255,255,255,0.7); }

        /* Form grid */
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--spacing-4); }
        .form-group-white { margin-bottom: var(--spacing-4); }
        .form-group-white:last-child { margin-bottom: 0; }
        .form-label-white { display: block; font-size: var(--font-size-sm); color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-2); }
        .form-input-white {
            width: 100%;
            padding: var(--spacing-3) var(--spacing-4);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: var(--border-radius-sm);
            background-color: rgba(255,255,255,0.1);
            color: white;
            font-size: var(--font-size-sm);
        }
        .form-input-white::placeholder { color: rgba(255,255,255,0.5); }
        .form-input-white:focus { outline: none; border-color: var(--color-primary); }

        /* User assigned card */
        .user-assigned {
            display: flex;
            align-items: center;
            gap: var(--spacing-3);
            padding: var(--spacing-3) var(--spacing-4);
            background-color: rgba(255,255,255,0.1);
            border-radius: var(--border-radius-sm);
            margin-bottom: var(--spacing-4);
        }
        .user-assigned-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--color-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--font-size-sm);
            font-weight: 600;
        }
        .user-assigned-info { flex: 1; }
        .user-assigned-name { font-size: var(--font-size-sm); font-weight: 500; }
        .user-assigned-role { font-size: var(--font-size-xs); color: rgba(255,255,255,0.6); }

        /* Stats bar */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--spacing-4);
            margin-bottom: var(--spacing-6);
        }
        .stat-bar-item {
            background-color: var(--bg-card);
            border-radius: var(--border-radius);
            padding: var(--spacing-4) var(--spacing-5);
            text-align: center;
        }
        .stat-bar-label { font-size: var(--font-size-xs); color: var(--text-secondary); margin-bottom: var(--spacing-1); }
        .stat-bar-value { font-size: var(--font-size-xl); font-weight: 700; color: var(--text-primary); }

        /* Table specific */
        .ruta-info { display: flex; flex-direction: column; }
        .ruta-nombre { font-weight: 500; color: var(--text-primary); font-size: var(--font-size-sm); }
        .ruta-detalle { font-size: var(--font-size-xs); color: var(--text-muted); }
        .conductor-cell { display: flex; align-items: center; gap: var(--spacing-2); }
        .conductor-avatar-sm { width: 28px; height: 28px; border-radius: 50%; background-color: var(--sidebar-bg); color: white; display: flex; align-items: center; justify-content: center; font-size: var(--font-size-xs); font-weight: 600; }
        .conductor-nombre { font-size: var(--font-size-sm); color: var(--text-primary); }
        .vehiculo-cell { display: flex; align-items: center; gap: var(--spacing-2); }
        .vehiculo-icon { width: 28px; height: 28px; border-radius: var(--border-radius-sm); background-color: var(--color-info-light); color: var(--color-info); display: flex; align-items: center; justify-content: center; }
        .vehiculo-placa { font-size: var(--font-size-sm); color: var(--text-primary); }
        .vehiculo-tipo { font-size: var(--font-size-xs); color: var(--text-muted); }
    </style>
    <div class="app-container">
                    <div class="content-area">
                <div class="page-header">
                    <h2 class="page-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                        Asignación de Rutas
                    </h2>
                    <p class="page-subtitle">Asigna rutas, conductores y vehículos a cada paquete</p>
                </div>

                <!-- Form Card -->
                <div class="form-card-blue">
                    <div class="form-card-blue-header">
                        <div class="form-card-blue-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                        </div>
                        <div>
                            <div class="form-card-blue-title">Asignar Ruta</div>
                            <div class="form-card-blue-subtitle">Completa los campos requeridos</div>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group-white">
                            <label class="form-label-white">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                Paquete
                            </label>
                            <input type="text" class="form-input-white" placeholder="1 paquetes en espera...">
                        </div>
                        <div class="form-group-white">
                            <label class="form-label-white">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                                Ruta
                            </label>
                            <input type="text" class="form-input-white" placeholder="Selecciona una ruta">
                        </div>
                        <div class="form-group-white">
                            <label class="form-label-white">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                Conductor
                            </label>
                            <input type="text" class="form-input-white" placeholder="Selecciona un conductor">
                        </div>
                        <div class="form-group-white">
                            <label class="form-label-white">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                Vehículo
                            </label>
                            <input type="text" class="form-input-white" placeholder="Selecciona un vehículo">
                        </div>
                        <div class="form-group-white">
                            <label class="form-label-white">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                Fecha de asignación
                            </label>
                            <input type="date" class="form-input-white">
                        </div>
                        <div class="form-group-white">
                            <label class="form-label-white">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                Usuario asignador
                            </label>
                            <input type="text" class="form-input-white" placeholder="Registro">
                        </div>
                    </div>
                    <div class="user-assigned">
                        <div class="user-assigned-avatar">AS</div>
                        <div class="user-assigned-info">
                            <div class="user-assigned-name">Administrador Sistema</div>
                            <div class="user-assigned-role">Administrador</div>
                        </div>
                    </div>
                    <button class="btn-primary" style="width: 100%; justify-content: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Guardar asignación
                    </button>
                </div>

                <!-- Stats Bar -->
                <div class="stats-bar">
                    <div class="stat-bar-item">
                        <div class="stat-bar-label">Total asignaciones</div>
                        <div class="stat-bar-value">5</div>
                    </div>
                    <div class="stat-bar-item">
                        <div class="stat-bar-label">Rutas activas</div>
                        <div class="stat-bar-value">5</div>
                    </div>
                    <div class="stat-bar-item">
                        <div class="stat-bar-label">Conductores disp.</div>
                        <div class="stat-bar-value">4</div>
                    </div>
                    <div class="stat-bar-item">
                        <div class="stat-bar-label">Vehículos disp.</div>
                        <div class="stat-bar-value">3</div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="table-card">
                    <div class="table-card-header">
                        <div>
                            <h3 class="table-card-title">Historial de Asignaciones</h3>
                            <p class="table-card-subtitle">5 registros</p>
                        </div>
                        <div class="search-box">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" placeholder="Buscar tracking, ruta...">
                        </div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Paquete</th>
                                <th>Ruta</th>
                                <th>Conductor</th>
                                <th>Vehículo</th>
                                <th>Fecha asignación</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        <div>
                                            <div style="font-weight: 500;">TMS-2026-001</div>
                                            <div style="font-size: var(--font-size-xs); color: var(--text-muted);">Pendiente</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ruta-info">
                                        <span class="ruta-nombre">RUTA-CDM-GDL</span>
                                        <span class="ruta-detalle">Monterrey › Guadalajara</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm">CR</div>
                                        <span class="conductor-nombre">Carlos Ramírez Vega</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="vehiculo-cell">
                                        <div class="vehiculo-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect></svg></div>
                                        <div>
                                            <div class="vehiculo-placa">ABC-123</div>
                                            <div class="vehiculo-tipo">Camioneta Ford</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fecha-cell"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>2026-02-10</td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm" style="background-color: var(--color-primary);">AD</div>
                                        <span class="conductor-nombre">Administrador</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        <div>
                                            <div style="font-weight: 500;">TMS-2026-002</div>
                                            <div style="font-size: var(--font-size-xs); color: var(--text-muted);">En tránsito</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ruta-info">
                                        <span class="ruta-nombre">RUTA-MTY-CDM</span>
                                        <span class="ruta-detalle">Monterrey › Ciudad de México</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm">LH</div>
                                        <span class="conductor-nombre">Luis Hernández Torres</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="vehiculo-cell">
                                        <div class="vehiculo-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect></svg></div>
                                        <div>
                                            <div class="vehiculo-placa">MNO-789</div>
                                            <div class="vehiculo-tipo">Van Mercedes</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fecha-cell"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>2026-02-14</td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm" style="background-color: var(--color-info);">OP</div>
                                        <span class="conductor-nombre">Operador</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        <div>
                                            <div style="font-weight: 500;">TMS-2026-003</div>
                                            <div style="font-size: var(--font-size-xs); color: var(--text-muted);">Pendiente</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ruta-info">
                                        <span class="ruta-nombre">RUTA-MTY-CDM</span>
                                        <span class="ruta-detalle">Querétaro › Ciudad de México</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm">PM</div>
                                        <span class="conductor-nombre">Pedro Morales Castro</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="vehiculo-cell">
                                        <div class="vehiculo-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect></svg></div>
                                        <div>
                                            <div class="vehiculo-placa">ABC-123</div>
                                            <div class="vehiculo-tipo">Camioneta Ford</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fecha-cell"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>2026-02-15</td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm" style="background-color: var(--color-primary);">AD</div>
                                        <span class="conductor-nombre">Administrador</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        <div>
                                            <div style="font-weight: 500;">TMS-2026-004</div>
                                            <div style="font-size: var(--font-size-xs); color: var(--text-muted);">En tránsito</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ruta-info">
                                        <span class="ruta-nombre">RUTA-QRO-CUN</span>
                                        <span class="ruta-detalle">Querétaro › Cancún</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm">AV</div>
                                        <span class="conductor-nombre">Andrés Vega Jiménez</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="vehiculo-cell">
                                        <div class="vehiculo-icon" style="background-color: #f3e8ff; color: #9333ea;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="5.5" cy="17.5" r="3.5"></circle><circle cx="18.5" cy="17.5" r="3.5"></circle></svg></div>
                                        <div>
                                            <div class="vehiculo-placa">STU-345</div>
                                            <div class="vehiculo-tipo">Pickup Toyota</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fecha-cell"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>2026-02-16</td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm" style="background-color: var(--color-info);">OP</div>
                                        <span class="conductor-nombre">Operador</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        <div>
                                            <div style="font-weight: 500;">TMS-2026-007</div>
                                            <div style="font-size: var(--font-size-xs); color: var(--text-muted);">Pendiente</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ruta-info">
                                        <span class="ruta-nombre">RUTA-CHI-PUE</span>
                                        <span class="ruta-detalle">Chihuahua › Puebla</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm">CR</div>
                                        <span class="conductor-nombre">Carlos Ramírez Vega</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="vehiculo-cell">
                                        <div class="vehiculo-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect></svg></div>
                                        <div>
                                            <div class="vehiculo-placa">MNO-789</div>
                                            <div class="vehiculo-tipo">Van Mercedes</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fecha-cell"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>2026-02-19</td>
                                <td>
                                    <div class="conductor-cell">
                                        <div class="conductor-avatar-sm" style="background-color: var(--color-primary);">AD</div>
                                        <span class="conductor-nombre">Administrador</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-footer" style="display: flex; justify-content: space-between; align-items: center;">
                        <span>5 de 5 asignaciones</span>
                        <span style="color: var(--color-success); font-size: var(--font-size-sm);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                            5 rutas operativas
                        </span>
                    </div>
                </div>
            </div>

    </div>
    
@endsection