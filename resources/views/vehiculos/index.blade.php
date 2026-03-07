@extends('layouts.app')

@section('title', 'Dashboard - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
<style>
    /* Vehicle type grid */
        .vehicle-type-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--spacing-3);
        }

        .vehicle-type-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--spacing-2);
            padding: var(--spacing-4);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--bg-card);
            font-size: var(--font-size-xs);
            color: var(--text-secondary);
            transition: all 0.2s;
        }

        .vehicle-type-btn:hover {
            border-color: var(--color-primary);
            color: var(--text-primary);
        }

        .vehicle-type-btn.active {
            background-color: var(--color-warning-light);
            border-color: var(--color-warning);
            color: var(--color-warning);
        }

        /* Capacity presets */
        .capacity-presets {
            display: flex;
            gap: var(--spacing-2);
            margin-top: var(--spacing-3);
        }

        .capacity-btn {
            padding: var(--spacing-2) var(--spacing-3);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--bg-card);
            font-size: var(--font-size-xs);
            color: var(--text-secondary);
            transition: all 0.2s;
        }

        .capacity-btn:hover {
            border-color: var(--color-primary);
            color: var(--text-primary);
        }

        .capacity-btn.active {
            background-color: var(--color-warning-light);
            border-color: var(--color-warning);
            color: var(--color-warning);
        }

        /* Vehicle status options */
        .vehicle-status-options {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-3);
        }

        .vehicle-status-btn {
            display: flex;
            align-items: center;
            gap: var(--spacing-3);
            padding: var(--spacing-4);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--bg-card);
            font-size: var(--font-size-sm);
            color: var(--text-secondary);
            transition: all 0.2s;
            width: 100%;
        }

        .vehicle-status-btn:hover {
            border-color: var(--color-primary);
            color: var(--text-primary);
        }

        .vehicle-status-btn.active {
            background-color: var(--color-success-light);
            border-color: var(--color-success);
            color: var(--color-success);
        }
</style>
<div class="content-area">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="page-header-top">
                        <div>
                            <h2 class="page-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                                Vehículos
                            </h2>
                            <p class="page-subtitle">Administra la flota vehicular</p>
                        </div>
                        <button class="btn-primary" id="btnRegistrarVehiculo">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Registrar vehículo
                        </button>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Total flota</div>
                            <div class="stat-value">6</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Disponibles</div>
                            <div class="stat-value" class="text-success">3</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon yellow">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">En ruta</div>
                            <div class="stat-value" class="text-warning">2</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon red">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Mantenimiento</div>
                            <div class="stat-value" class="text-danger">1</div>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="table-card">
                    <div class="table-card-header">
                        <div>
                            <h3 class="table-card-title">Listado de Vehículos</h3>
                            <p class="table-card-subtitle">6 vehículos encontrados</p>
                        </div>
                        <div class="table-filters">
                            <div class="filter-tabs">
                                <button class="filter-tab active">Todos</button>
                                <button class="filter-tab">Disponible</button>
                                <button class="filter-tab">En ruta</button>
                                <button class="filter-tab">Mant.</button>
                            </div>
                            <div class="search-box">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" placeholder="Buscar placas, tipo...">
                            </div>
                        </div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Placas</th>
                                <th>Tipo</th>
                                <th>Capacidad de carga</th>
                                <th>Estado</th>
                                <th>Fecha de registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: var(--color-info-light); color: var(--color-info);">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="1" y="3" width="15" height="13"></rect>
                                            </svg>
                                        </div>
                                        <span class="user-name-text">ABC-123-MX</span>
                                    </div>
                                </td>
                                <td>Camioneta</td>
                                <td>
                                    <div class="user-cell">
                                        <div style="width: 60px; height: 6px; background-color: var(--border-color); border-radius: 3px; overflow: hidden;">
                                            <div style="width: 60%; height: 100%; background-color: var(--color-info); border-radius: 3px;"></div>
                                        </div>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path>
                                        </svg>
                                        <span>800 kg</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge active">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Disponible
                                    </span>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2024-01-10</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: #f3e8ff; color: #9333ea;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="5.5" cy="17.5" r="3.5"></circle>
                                                <circle cx="18.5" cy="17.5" r="3.5"></circle>
                                                <path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h2"></path>
                                            </svg>
                                        </div>
                                        <span class="user-name-text">XYZ-456-MX</span>
                                    </div>
                                </td>
                                <td>Motocicleta</td>
                                <td>
                                    <div class="user-cell">
                                        <div style="width: 60px; height: 6px; background-color: var(--border-color); border-radius: 3px; overflow: hidden;">
                                            <div style="width: 30%; height: 100%; background-color: #d4d4d4; border-radius: 3px;"></div>
                                        </div>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path>
                                        </svg>
                                        <span>30 kg</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge warning">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                        </svg>
                                        En ruta
                                    </span>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2024-03-05</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: var(--color-info-light); color: var(--color-info);">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="1" y="3" width="15" height="13"></rect>
                                            </svg>
                                        </div>
                                        <span class="user-name-text">MNO-789-MX</span>
                                    </div>
                                </td>
                                <td>Van</td>
                                <td>
                                    <div class="user-cell">
                                        <div style="width: 60px; height: 6px; background-color: var(--border-color); border-radius: 3px; overflow: hidden;">
                                            <div style="width: 80%; height: 100%; background-color: var(--color-info); border-radius: 3px;"></div>
                                        </div>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path>
                                        </svg>
                                        <span>1.5 t</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge active">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Disponible
                                    </span>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2024-05-18</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: var(--color-info-light); color: var(--color-info);">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="1" y="3" width="15" height="13"></rect>
                                            </svg>
                                        </div>
                                        <span class="user-name-text">PQR-012-MX</span>
                                    </div>
                                </td>
                                <td>Pickup</td>
                                <td>
                                    <div class="user-cell">
                                        <div style="width: 60px; height: 6px; background-color: var(--border-color); border-radius: 3px; overflow: hidden;">
                                            <div style="width: 50%; height: 100%; background-color: var(--color-info); border-radius: 3px;"></div>
                                        </div>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path>
                                        </svg>
                                        <span>600 kg</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge inactive">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                        </svg>
                                        Mantenimiento
                                    </span>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2023-11-22</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: var(--color-info-light); color: var(--color-info);">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="1" y="3" width="15" height="13"></rect>
                                            </svg>
                                        </div>
                                        <span class="user-name-text">STU-345-MX</span>
                                    </div>
                                </td>
                                <td>Camioneta</td>
                                <td>
                                    <div class="user-cell">
                                        <div style="width: 60px; height: 6px; background-color: var(--border-color); border-radius: 3px; overflow: hidden;">
                                            <div style="width: 100%; height: 100%; background-color: var(--color-info); border-radius: 3px;"></div>
                                        </div>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path>
                                        </svg>
                                        <span>2 t</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge active">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Disponible
                                    </span>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2023-08-14</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: #f3e8ff; color: #9333ea;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="5.5" cy="17.5" r="3.5"></circle>
                                                <circle cx="18.5" cy="17.5" r="3.5"></circle>
                                                <path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h2"></path>
                                            </svg>
                                        </div>
                                        <span class="user-name-text">VWX-678-MX</span>
                                    </div>
                                </td>
                                <td>Motocicleta</td>
                                <td>
                                    <div class="user-cell">
                                        <div style="width: 60px; height: 6px; background-color: var(--border-color); border-radius: 3px; overflow: hidden;">
                                            <div style="width: 25%; height: 100%; background-color: #d4d4d4; border-radius: 3px;"></div>
                                        </div>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path>
                                        </svg>
                                        <span>25 kg</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge warning">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                        </svg>
                                        En ruta
                                    </span>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2025-02-01</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-footer">
                        Mostrando 6 de 6 vehículos
                    </div>
                </div>
            </div>

            <!-- Modal Registrar Vehículo -->
    <div class="modal-overlay hidden" id="modalRegistrarVehiculo">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Registrar vehículo</h3>
                    <p class="modal-subtitle">Completa todos los campos</p>
                </div>
                <button class="modal-close" id="btnCerrarModal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Placas</label>
                    <input type="text" class="form-input" placeholder="ABC-123-MX">
                    <p class="form-hint">Formato: ABC-000-MX</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Tipo de vehículo</label>
                    <div class="vehicle-type-grid">
                        <button class="vehicle-type-btn active">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                            </svg>
                            Camioneta
                        </button>
                        <button class="vehicle-type-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="5.5" cy="17.5" r="3.5"></circle>
                                <circle cx="18.5" cy="17.5" r="3.5"></circle>
                            </svg>
                            Motocicleta
                        </button>
                        <button class="vehicle-type-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                            </svg>
                            Van
                        </button>
                        <button class="vehicle-type-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                            </svg>
                            Pickup
                        </button>
                        <button class="vehicle-type-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                            </svg>
                            Camión
                        </button>
                        <button class="vehicle-type-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                            </svg>
                            Furgoneta
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Capacidad de carga (kg)</label>
                    <div class="user-cell">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); position: absolute; left: var(--spacing-4); top: 50%; transform: translateY(-50%);">
                            <path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path>
                        </svg>
                        <input type="number" class="form-input" placeholder="800" style="padding-left: var(--spacing-10);">
                    </div>
                    <div class="capacity-presets">
                        <button class="capacity-btn">30kg</button>
                        <button class="capacity-btn">300kg</button>
                        <button class="capacity-btn active">800kg</button>
                        <button class="capacity-btn">1.5t</button>
                        <button class="capacity-btn">2t</button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Estado del vehículo</label>
                    <div class="vehicle-status-options">
                        <button class="vehicle-status-btn active">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Disponible
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: auto;">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </button>
                        <button class="vehicle-status-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                            </svg>
                            En ruta
                        </button>
                        <button class="vehicle-status-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                            </svg>
                            Mantenimiento
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" id="btnCancelar">Cancelar</button>
                <button class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    Registrar vehículo
                </button>
            </div>
        </div>
    </div>

    <script>
        // Toggle del sidebar en móvil
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            });
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }

        // Modal
        const btnRegistrarVehiculo = document.getElementById('btnRegistrarVehiculo');
        const modalRegistrarVehiculo = document.getElementById('modalRegistrarVehiculo');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');

        btnRegistrarVehiculo.addEventListener('click', function() {
            modalRegistrarVehiculo.classList.remove('hidden');
        });

        btnCerrarModal.addEventListener('click', function() {
            modalRegistrarVehiculo.classList.add('hidden');
        });

        btnCancelar.addEventListener('click', function() {
            modalRegistrarVehiculo.classList.add('hidden');
        });

        modalRegistrarVehiculo.addEventListener('click', function(e) {
            if (e.target === modalRegistrarVehiculo) {
                modalRegistrarVehiculo.classList.add('hidden');
            }
        });

        // Tipo de vehículo
        const vehicleTypeBtns = document.querySelectorAll('.vehicle-type-btn');
        vehicleTypeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                vehicleTypeBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Capacidad presets
        const capacityBtns = document.querySelectorAll('.capacity-btn');
        capacityBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                capacityBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Estado del vehículo
        const vehicleStatusBtns = document.querySelectorAll('.vehicle-status-btn');
        vehicleStatusBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                vehicleStatusBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
    @endsection