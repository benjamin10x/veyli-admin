@extends('layouts.app')

@section('title', 'Dashboard - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
<style>
        /* Status cards for shipments */
        .shipment-stats {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: var(--spacing-4);
            margin-bottom: var(--spacing-6);
        }
        .shipment-stat-card {
            background-color: var(--bg-card);
            border-radius: var(--border-radius);
            padding: var(--spacing-4) var(--spacing-5);
            display: flex;
            align-items: center;
            gap: var(--spacing-3);
        }
        .shipment-stat-icon {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .shipment-stat-info { flex: 1; }
        .shipment-stat-label {
            font-size: var(--font-size-xs);
            color: var(--text-secondary);
        }
        .shipment-stat-value {
            font-size: var(--font-size-xl);
            font-weight: 700;
        }

        /* Tracking code style */
        .tracking-code {
            display: flex;
            align-items: center;
            gap: var(--spacing-2);
            font-weight: 600;
            color: var(--text-primary);
        }
        .tracking-icon {
            width: 28px;
            height: 28px;
            border-radius: var(--border-radius-sm);
            background-color: var(--color-info-light);
            color: var(--color-info);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Estado badges específicos */
        .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-2);
            padding: var(--spacing-1) var(--spacing-3);
            border-radius: var(--border-radius-sm);
            font-size: var(--font-size-xs);
            font-weight: 500;
        }
        .estado-badge.pendiente { background-color: #f3f4f6; color: #6b7280; }
        .estado-badge.transito { background-color: #fef3c7; color: #d97706; }
        .estado-badge.entregado { background-color: #dcfce7; color: #16a34a; }
        .estado-badge.retrasado { background-color: #fee2e2; color: #dc2626; }
        .estado-badge.cancelado { background-color: #f3f4f6; color: #6b7280; }

        /* Cliente cell */
        .cliente-cell { display: flex; flex-direction: column; }
        .cliente-nombre { font-weight: 500; color: var(--text-primary); }
        .cliente-email { font-size: var(--font-size-xs); color: var(--text-muted); }

        /* Dirección cell */
        .direccion-cell {
            display: flex;
            align-items: flex-start;
            gap: var(--spacing-2);
            color: var(--text-secondary);
            font-size: var(--font-size-sm);
        }

        /* Fecha cell */
        .fecha-cell {
            display: flex;
            align-items: center;
            gap: var(--spacing-2);
            color: var(--text-secondary);
            font-size: var(--font-size-sm);
        }
        .fecha-vencida { color: var(--color-danger); }
    </style>
    <!-- Content Area -->
            <div class="content-area">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="page-header-top">
                        <div>
                            <h2 class="page-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                Envíos / Paquetes
                            </h2>
                            <p class="page-subtitle">Gestiona y monitorea todos los envíos</p>
                        </div>
                        <a href="{{ route('envios.registrar') }}" class="btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Registrar envío
                        </a>
                    </div>
                </div>

                <!-- Shipment Stats -->
                <div class="shipment-stats">
                    <div class="shipment-stat-card">
                        <div class="shipment-stat-icon" style="background-color: #9ca3af;"></div>
                        <div class="shipment-stat-info">
                            <div class="shipment-stat-label">Pendiente</div>
                            <div class="shipment-stat-value" style="color: #9ca3af;">1</div>
                        </div>
                    </div>
                    <div class="shipment-stat-card">
                        <div class="shipment-stat-icon" style="background-color: #f59e0b;"></div>
                        <div class="shipment-stat-info">
                            <div class="shipment-stat-label">En tránsito</div>
                            <div class="shipment-stat-value" style="color: #f59e0b;">3</div>
                        </div>
                    </div>
                    <div class="shipment-stat-card">
                        <div class="shipment-stat-icon" style="background-color: #22c55e;"></div>
                        <div class="shipment-stat-info">
                            <div class="shipment-stat-label">Entregado</div>
                            <div class="shipment-stat-value" style="color: #22c55e;">2</div>
                        </div>
                    </div>
                    <div class="shipment-stat-card">
                        <div class="shipment-stat-icon" style="background-color: #ef4444;"></div>
                        <div class="shipment-stat-info">
                            <div class="shipment-stat-label">Retrasado</div>
                            <div class="shipment-stat-value" style="color: #ef4444;">1</div>
                        </div>
                    </div>
                    <div class="shipment-stat-card">
                        <div class="shipment-stat-icon" style="background-color: #6b7280;"></div>
                        <div class="shipment-stat-info">
                            <div class="shipment-stat-label">Cancelado</div>
                            <div class="shipment-stat-value" style="color: #6b7280;">1</div>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="table-card">
                    <div class="table-card-header">
                        <div>
                            <h3 class="table-card-title">Listado de Envíos</h3>
                            <p class="table-card-subtitle">8 envíos encontrados</p>
                        </div>
                        <div class="search-box">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" placeholder="Buscar tracking, cliente...">
                        </div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Código tracking</th>
                                <th>Cliente</th>
                                <th>Dirección destino</th>
                                <th>Estado paquete</th>
                                <th>Fecha registro</th>
                                <th>F. est. entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        TMS-2026-001
                                    </div>
                                </td>
                                <td>
                                    <div class="cliente-cell">
                                        <span class="cliente-nombre">Juan García López</span>
                                        <span class="cliente-email">juan.garcia@email.com</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="direccion-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); flex-shrink: 0;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        Calle Reforma 567, Gua...
                                    </div>
                                </td>
                                <td><span class="estado-badge entregado"><span style="width: 6px; height: 6px; background-color: #22c55e; border-radius: 50%;"></span>Entregado</span></td>
                                <td>
                                    <div class="fecha-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-10</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fecha-cell fecha-vencida">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-19</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        TMS-2026-002
                                    </div>
                                </td>
                                <td>
                                    <div class="cliente-cell">
                                        <span class="cliente-nombre">María Martínez Ruiz</span>
                                        <span class="cliente-email">maria.martinez@email.com</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="direccion-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); flex-shrink: 0;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        Blvd. Díaz Ordaz 890, M...
                                    </div>
                                </td>
                                <td><span class="estado-badge transito"><span style="width: 6px; height: 6px; background-color: #f59e0b; border-radius: 50%;"></span>En tránsito</span></td>
                                <td>
                                    <div class="fecha-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-10</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fecha-cell fecha-vencida">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-19</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        TMS-2026-003
                                    </div>
                                </td>
                                <td>
                                    <div class="cliente-cell">
                                        <span class="cliente-nombre">Carlos Hernández Torres</span>
                                        <span class="cliente-email">carlos.h@empresa.mx</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="direccion-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); flex-shrink: 0;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        Av. Insurgentes Sur 123...
                                    </div>
                                </td>
                                <td><span class="estado-badge retrasado"><span style="width: 6px; height: 6px; background-color: #ef4444; border-radius: 50%;"></span>Retrasado</span></td>
                                    <td>
                                    <div class="fecha-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-10</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fecha-cell fecha-vencida">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-19</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        TMS-2026-004
                                    </div>
                                </td>
                                <td>
                                    <div class="cliente-cell">
                                        <span class="cliente-nombre">Roberto Ramírez Castro</span>
                                        <span class="cliente-email">roberto.r@outlook.com</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="direccion-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); flex-shrink: 0;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        Av. Tulum 456, Cancún,...
                                    </div>
                                </td>
                                <td><span class="estado-badge transito"><span style="width: 6px; height: 6px; background-color: #f59e0b; border-radius: 50%;"></span>En tránsito</span></td>
                                                                <td>
                                    <div class="fecha-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-10</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fecha-cell fecha-vencida">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-19</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        TMS-2026-005
                                    </div>
                                </td>
                                <td>
                                    <div class="cliente-cell">
                                        <span class="cliente-nombre">Sofía Vega Morales</span>
                                        <span class="cliente-email">sofia.vega@gmail.com</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="direccion-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); flex-shrink: 0;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        Blvd. Torres Landa 90, L...
                                    </div>
                                </td>
                                <td><span class="estado-badge pendiente"><span style="width: 6px; height: 6px; background-color: #9ca3af; border-radius: 50%;"></span>Pendiente</span></td>
                                                                <td>
                                    <div class="fecha-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-10</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fecha-cell fecha-vencida">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-19</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        TMS-2026-006
                                    </div>
                                </td>
                                <td>
                                    <div class="cliente-cell">
                                        <span class="cliente-nombre">Valeria Cruz Mendoza</span>
                                        <span class="cliente-email">valeria.cruz@email.com</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="direccion-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); flex-shrink: 0;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        Calle Juárez 321, Puebla...
                                    </div>
                                </td>
                                <td><span class="estado-badge entregado"><span style="width: 6px; height: 6px; background-color: #22c55e; border-radius: 50%;"></span>Entregado</span></td>
                                                                <td>
                                    <div class="fecha-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-10</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fecha-cell fecha-vencida">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-19</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        TMS-2026-007
                                    </div>
                                </td>
                                <td>
                                    <div class="cliente-cell">
                                        <span class="cliente-nombre">Juan García López</span>
                                        <span class="cliente-email">juan.garcia@email.com</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="direccion-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); flex-shrink: 0;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        Calle Aldama 203, Chih...
                                    </div>
                                </td>
                                <td><span class="estado-badge transito"><span style="width: 6px; height: 6px; background-color: #f59e0b; border-radius: 50%;"></span>En tránsito</span></td>
                                                                <td>
                                    <div class="fecha-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-10</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fecha-cell fecha-vencida">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-19</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tracking-code">
                                        <div class="tracking-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></div>
                                        TMS-2026-008
                                    </div>
                                </td>
                                <td>
                                    <div class="cliente-cell">
                                        <span class="cliente-nombre">Carlos Hernández Torres</span>
                                        <span class="cliente-email">carlos.h@empresa.mx</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="direccion-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); flex-shrink: 0;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        Av. Corregidora 77, Que...
                                    </div>
                                </td>
                                <td><span class="estado-badge cancelado"><span style="width: 6px; height: 6px; background-color: #6b7280; border-radius: 50%;"></span>Cancelado</span></td>
                                                                <td>
                                    <div class="fecha-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-10</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fecha-cell fecha-vencida">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>2026-02-19</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-footer">
                        Mostrando 8 de 8 envíos
                    </div>
                </div>
            </div>
        
@endsection