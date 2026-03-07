@extends('layouts.app')

@section('title', 'Usuarios - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
    <!-- Content Area -->
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-top">
                <div>
                    <h2 class="page-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Gestión de Usuarios
                    </h2>
                    <p class="page-subtitle">Gestiona todos los usuarios del sistema</p>
                </div>
                <button class="btn-primary" id="btnRegistrarUsuario">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Registrar usuario
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total usuarios</div>
                    <div class="stat-value">24</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Usuarios activos</div>
                    <div class="stat-value text-success">20</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Usuarios inactivos</div>
                    <div class="stat-value text-danger">4</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Roles del sistema</div>
                    <div class="stat-value text-purple">5</div>
                </div>
            </div>
        </div>

        <!-- Feature Cards -->
        <div class="cards-grid">
            <div class="feature-card">
                <div class="feature-card-icon blue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <h3 class="feature-card-title">Gestión de Roles</h3>
                <p class="feature-card-desc">Crear, editar y administrar roles del sistema</p>
                <a href="{{ route('roles.index') }}" class="feature-card-link blue">
                    Ir a Roles
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
            <div class="feature-card">
                <div class="feature-card-icon yellow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </div>
                <h3 class="feature-card-title">Reportes</h3>
                <p class="feature-card-desc">Analítica y métricas del sistema</p>
                <a href="{{ route('reportes.index') }}" class="feature-card-link yellow">
                    Ver Reportes
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
            <div class="feature-card">
                <div class="feature-card-icon green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 class="feature-card-title">Clientes</h3>
                <p class="feature-card-desc">Gestión de clientes del sistema</p>
                <a href="{{ route('clientes.index') }}" class="feature-card-link green">
                    Gestionar
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <h3 class="table-card-title">Listado de Usuarios</h3>
                    <p class="table-card-subtitle">12 usuarios encontrados</p>
                </div>
                <div class="search-box">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Buscar usuario, email...">
                </div>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Fecha registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar-sm" style="background-color: #d4a84b;">AD</div>
                                <div>
                                    <div class="user-name">Admin User</div>
                                    <div class="user-email">admin@veyli.com</div>
                                </div>
                            </div>
                        </td>
                        <td>admin@veyli.com</td>
                        <td>
                            <span style="background-color: #dbeafe; color: #0284c7; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 500;">Administrador</span>
                        </td>
                        <td>
                            <span style="color: #16a34a; font-weight: 500;">Activo</span>
                        </td>
                        <td>2026-01-15</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button class="action-btn edit" title="Editar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                                <button class="action-btn text-danger" title="Eliminar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar-sm" style="background-color: #3b82f6;">JC</div>
                                <div>
                                    <div class="user-name">Juan Carlos López</div>
                                    <div class="user-email">juan.lopez@veyli.com</div>
                                </div>
                            </div>
                        </td>
                        <td>juan.lopez@veyli.com</td>
                        <td>
                            <span style="background-color: #fef3c7; color: #d97706; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 500;">Operador</span>
                        </td>
                        <td>
                            <span style="color: #16a34a; font-weight: 500;">Activo</span>
                        </td>
                        <td>2026-02-01</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button class="action-btn edit" title="Editar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                                <button class="action-btn text-danger" title="Eliminar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar-sm" style="background-color: #ef4444;">MR</div>
                                <div>
                                    <div class="user-name">María Rodríguez</div>
                                    <div class="user-email">maria.r@veyli.com</div>
                                </div>
                            </div>
                        </td>
                        <td>maria.r@veyli.com</td>
                        <td>
                            <span style="background-color: #dcfce7; color: #16a34a; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 500;">Cliente</span>
                        </td>
                        <td>
                            <span style="color: #16a34a; font-weight: 500;">Activo</span>
                        </td>
                        <td>2026-02-05</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button class="action-btn edit" title="Editar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                                <button class="action-btn text-danger" title="Eliminar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar-sm" style="background-color: #f59e0b;">CF</div>
                                <div>
                                    <div class="user-name">Carlos Flores</div>
                                    <div class="user-email">carlos.f@veyli.com</div>
                                </div>
                            </div>
                        </td>
                        <td>carlos.f@veyli.com</td>
                        <td>
                            <span style="background-color: #fee2e2; color: #dc2626; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 500;">Conductor</span>
                        </td>
                        <td>
                            <span style="color: #6b7280; font-weight: 500;">Inactivo</span>
                        </td>
                        <td>2026-01-20</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button class="action-btn edit" title="Editar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                                <button class="action-btn text-danger" title="Eliminar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="table-footer">
                Mostrando 4 de 12 usuarios
            </div>
        </div>
    </div>

    <style>
        .user-cell {
            display: flex;
            align-items: center;
            gap: var(--spacing-3);
        }

        .user-avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 12px;
        }

        .user-name {
            font-weight: 500;
            color: var(--text-primary);
            font-size: var(--font-size-sm);
        }

        .user-email {
            font-size: var(--font-size-xs);
            color: var(--text-muted);
        }

        .action-btn {
            padding: var(--spacing-2);
            border-radius: var(--border-radius-sm);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s;
        }

        .action-btn:hover {
            background-color: var(--bg-main);
            color: var(--text-primary);
        }

        .action-btn.edit {
            color: var(--color-info);
        }

        .action-btn.edit:hover {
            background-color: var(--color-info-light);
        }
    </style>
@endsection