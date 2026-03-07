@extends('layouts.app')

@section('title', 'Dashboard - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
    <style>

        /* Estado Cards */
        .estado-cards { display: grid; grid-template-columns: repeat(5, 1fr); gap: var(--spacing-4); margin-bottom: var(--spacing-6); }
        .estado-card { background-color: var(--bg-card); border-radius: var(--border-radius); padding: var(--spacing-5); border-top: 3px solid; }
        .estado-card.pendiente { border-color: #9ca3af; }
        .estado-card.transito { border-color: #f59e0b; }
        .estado-card.entregado { border-color: #22c55e; }
        .estado-card.retrasado { border-color: #ef4444; }
        .estado-card.cancelado { border-color: #6b7280; }
        .estado-card-header { display: flex; align-items: center; gap: var(--spacing-2); margin-bottom: var(--spacing-3); }
        .estado-card-dot { width: 10px; height: 10px; border-radius: 50%; }
        .estado-card-title { font-size: var(--font-size-sm); font-weight: 600; }
        .estado-card.pendiente .estado-card-title { color: #6b7280; }
        .estado-card.transito .estado-card-title { color: #d97706; }
        .estado-card.entregado .estado-card-title { color: #16a34a; }
        .estado-card.retrasado .estado-card-title { color: #dc2626; }
        .estado-card.cancelado .estado-card-title { color: #6b7280; }
        .estado-card-desc { font-size: var(--font-size-xs); color: var(--text-secondary); line-height: 1.5; }

        /* Color badge in table */
        .color-badge { display: inline-flex; align-items: center; gap: var(--spacing-2); }
        .color-dot { width: 24px; height: 24px; border-radius: var(--border-radius-sm); }
        .color-code { font-family: monospace; font-size: var(--font-size-sm); color: var(--text-secondary); }

        /* Estado badge in table */
        .estado-table-badge { display: inline-flex; align-items: center; gap: var(--spacing-2); padding: var(--spacing-1) var(--spacing-3); border-radius: var(--border-radius-sm); font-size: var(--font-size-xs); font-weight: 500; }
        .estado-table-badge.pendiente { background-color: #f3f4f6; color: #6b7280; }
        .estado-table-badge.transito { background-color: #fef3c7; color: #d97706; }
        .estado-table-badge.entregado { background-color: #dcfce7; color: #16a34a; }
        .estado-table-badge.retrasado { background-color: #fee2e2; color: #dc2626; }
        .estado-table-badge.cancelado { background-color: #f3f4f6; color: #6b7280; }

        /* Modal specific styles */
        .modal-tabs { display: flex; gap: var(--spacing-2); margin-bottom: var(--spacing-5); }
        .modal-tab { padding: var(--spacing-2) var(--spacing-4); border-radius: var(--border-radius-sm); font-size: var(--font-size-sm); font-weight: 500; cursor: pointer; transition: all 0.2s; }
        .modal-tab.active { background-color: var(--sidebar-bg); color: white; }
        .modal-tab:not(.active) { color: var(--text-secondary); }
        .modal-tab:not(.active):hover { color: var(--text-primary); }

        .color-picker { display: grid; grid-template-columns: repeat(5, 1fr); gap: var(--spacing-3); margin-bottom: var(--spacing-4); }
        .color-option { width: 40px; height: 40px; border-radius: var(--border-radius-sm); cursor: pointer; border: 2px solid transparent; transition: all 0.2s; }
        .color-option:hover { transform: scale(1.1); }
        .color-option.selected { border-color: var(--text-primary); box-shadow: 0 0 0 2px white, 0 0 0 4px var(--text-primary); }

        .color-input-group { display: flex; align-items: center; gap: var(--spacing-3); }
        .color-preview { width: 48px; height: 48px; border-radius: var(--border-radius-sm); }
        .color-input { flex: 1; }
    </style>
    <div class="content-area">
                <div class="page-header">
                    <div class="page-header-top">
                        <div>
                            <h2 class="page-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                Estados de Paquete
                            </h2>
                            <p class="page-subtitle">Administra los estados disponibles para los paquetes</p>
                        </div>
                        <button class="btn-primary" id="btnCrearEstado">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Crear estado
                        </button>
                    </div>
                </div>

                <!-- Estado Cards -->
                <div class="estado-cards">
                    <div class="estado-card pendiente">
                        <div class="estado-card-header">
                            <div class="estado-card-dot" style="background-color: #9ca3af;"></div>
                            <span class="estado-card-title">Pendiente</span>
                        </div>
                        <p class="estado-card-desc">El paquete está registrado y en espera de ser procesado.</p>
                    </div>
                    <div class="estado-card transito">
                        <div class="estado-card-header">
                            <div class="estado-card-dot" style="background-color: #f59e0b;"></div>
                            <span class="estado-card-title">En tránsito</span>
                        </div>
                        <p class="estado-card-desc">El paquete está siendo transportado hacia su destino.</p>
                    </div>
                    <div class="estado-card entregado">
                        <div class="estado-card-header">
                            <div class="estado-card-dot" style="background-color: #22c55e;"></div>
                            <span class="estado-card-title">Entregado</span>
                        </div>
                        <p class="estado-card-desc">El paquete fue entregado exitosamente al destinatario.</p>
                    </div>
                    <div class="estado-card retrasado">
                        <div class="estado-card-header">
                            <div class="estado-card-dot" style="background-color: #ef4444;"></div>
                            <span class="estado-card-title">Retrasado</span>
                        </div>
                        <p class="estado-card-desc">El paquete presenta un retraso en su entrega.</p>
                    </div>
                    <div class="estado-card cancelado">
                        <div class="estado-card-header">
                            <div class="estado-card-dot" style="background-color: #6b7280;"></div>
                            <span class="estado-card-title">Cancelado</span>
                        </div>
                        <p class="estado-card-desc">El envío fue cancelado por el cliente o por el sistema.</p>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="table-card">
                    <div class="table-card-header">
                        <div>
                            <h3 class="table-card-title">Gestión de Estados</h3>
                            <p class="table-card-subtitle">5 estados registrados</p>
                        </div>
                        <div class="search-box">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" placeholder="Buscar estado...">
                        </div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre del estado</th>
                                <th>Color del estado</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: #f3f4f6; color: #6b7280;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>
                                        </div>
                                        <span class="estado-table-badge pendiente"><span style="width: 6px; height: 6px; background-color: #9ca3af; border-radius: 50%;"></span>Pendiente</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="color-badge">
                                        <div class="color-dot" style="background-color: #9ca3af;"></div>
                                        <span class="color-code">#9ca3af</span>
                                    </div>
                                </td>
                                <td>El paquete está registrado y en espera de ser pr...</td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: #fef3c7; color: #d97706;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>
                                        </div>
                                        <span class="estado-table-badge transito"><span style="width: 6px; height: 6px; background-color: #f59e0b; border-radius: 50%;"></span>En tránsito</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="color-badge">
                                        <div class="color-dot" style="background-color: #f59e0b;"></div>
                                        <span class="color-code">#c8973b</span>
                                    </div>
                                </td>
                                <td>El paquete está siendo transportado hacia su de...</td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: #dcfce7; color: #16a34a;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>
                                        </div>
                                        <span class="estado-table-badge entregado"><span style="width: 6px; height: 6px; background-color: #22c55e; border-radius: 50%;"></span>Entregado</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="color-badge">
                                        <div class="color-dot" style="background-color: #22c55e;"></div>
                                        <span class="color-code">#22a05a</span>
                                    </div>
                                </td>
                                <td>El paquete fue entregado exitosamente al destin...</td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: #fee2e2; color: #dc2626;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>
                                        </div>
                                        <span class="estado-table-badge retrasado"><span style="width: 6px; height: 6px; background-color: #ef4444; border-radius: 50%;"></span>Retrasado</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="color-badge">
                                        <div class="color-dot" style="background-color: #ef4444;"></div>
                                        <span class="color-code">#d94f4f</span>
                                    </div>
                                </td>
                                <td>El paquete presenta un retraso en su entrega.</td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm" style="background-color: #f3f4f6; color: #6b7280;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>
                                        </div>
                                        <span class="estado-table-badge cancelado"><span style="width: 6px; height: 6px; background-color: #6b7280; border-radius: 50%;"></span>Cancelado</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="color-badge">
                                        <div class="color-dot" style="background-color: #6b7280;"></div>
                                        <span class="color-code">#6b7280</span>
                                    </div>
                                </td>
                                <td>El envío fue cancelado por el cliente o por el sist...</td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-footer">
                        Total: 5 estados definidos en el sistema
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Crear Estado -->
    <div class="modal-overlay hidden" id="modalCrearEstado">
        <div class="modal" style="max-width: 450px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--spacing-3);">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background-color: var(--color-info-light); color: var(--color-info); display: flex; align-items: center; justify-content: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Crear estado de paquete</h3>
                        <p class="modal-subtitle">Define el nombre, color y descripción</p>
                    </div>
                </div>
                <button class="modal-close" id="btnCerrarModal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-tabs">
                    <div class="modal-tab active">Formulario</div>
                    <div class="modal-tab">Vista previa</div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><circle cx="12" cy="12" r="10"></circle></svg>
                        Nombre del estado
                    </label>
                    <input type="text" class="form-input" placeholder="Ej: En revisión, Devuelto, En bodega...">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="3"></circle></svg>
                        Color del estado
                    </label>
                    <div class="color-picker">
                        <div class="color-option selected" style="background-color: #9ca3af;"></div>
                        <div class="color-option" style="background-color: #f59e0b;"></div>
                        <div class="color-option" style="background-color: #22c55e;"></div>
                        <div class="color-option" style="background-color: #ef4444;"></div>
                        <div class="color-option" style="background-color: #3b82f6;"></div>
                        <div class="color-option" style="background-color: #1e3a4a;"></div>
                        <div class="color-option" style="background-color: #c97a7a;"></div>
                        <div class="color-option" style="background-color: #4ade80;"></div>
                        <div class="color-option" style="background-color: #dc2626;"></div>
                        <div class="color-option" style="background-color: #facc15;"></div>
                    </div>
                    <div class="color-input-group">
                        <div class="color-preview" style="background-color: #9ca3af;"></div>
                        <input type="text" class="form-input color-input" value="#174f65">
                        <button class="btn-secondary" style="padding: var(--spacing-2) var(--spacing-4); font-size: var(--font-size-sm);">Vista previa</button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        Descripción
                    </label>
                    <textarea class="form-input" rows="3" placeholder="Describe qué significa este estado para el paquete..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" id="btnCancelar">Cancelar</button>
                <button class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    Crear estado
                </button>
            </div>
        </div>
    </div>
    <script>
                // Modal
        const btnCrearEstado = document.getElementById('btnCrearEstado');
        const modalCrearEstado = document.getElementById('modalCrearEstado');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');

        btnCrearEstado.addEventListener('click', () => modalCrearEstado.classList.remove('hidden'));
        btnCerrarModal.addEventListener('click', () => modalCrearEstado.classList.add('hidden'));
        btnCancelar.addEventListener('click', () => modalCrearEstado.classList.add('hidden'));
        modalCrearEstado.addEventListener('click', (e) => { if (e.target === modalCrearEstado) modalCrearEstado.classList.add('hidden'); });

        // Color picker
        const colorOptions = document.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', function() {
                colorOptions.forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    </script>
@endsection