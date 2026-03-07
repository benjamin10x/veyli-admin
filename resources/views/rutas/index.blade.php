@extends('layouts.app')

@section('title', 'Dashboard - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
 <style>

        /* Stats cards */
        .ruta-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--spacing-4); margin-bottom: var(--spacing-6); }
        .ruta-stat-card { background-color: var(--bg-card); border-radius: var(--border-radius); padding: var(--spacing-5); display: flex; align-items: center; gap: var(--spacing-4); }
        .ruta-stat-icon { width: 48px; height: 48px; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; }
        .ruta-stat-icon.blue { background-color: var(--color-info-light); color: var(--color-info); }
        .ruta-stat-icon.green { background-color: var(--color-success-light); color: var(--color-success); }
        .ruta-stat-icon.yellow { background-color: var(--color-warning-light); color: var(--color-warning); }
        .ruta-stat-icon.purple { background-color: #f3e8ff; color: #9333ea; }
        .ruta-stat-info { flex: 1; }
        .ruta-stat-label { font-size: var(--font-size-sm); color: var(--text-secondary); }
        .ruta-stat-value { font-size: var(--font-size-2xl); font-weight: 700; color: var(--text-primary); }

        /* Table specific */
        .ruta-cell { display: flex; flex-direction: column; }
        .ruta-nombre { font-weight: 500; color: var(--text-primary); }
        .ruta-detalle { font-size: var(--font-size-xs); color: var(--text-muted); }
        .origen-destino { display: flex; align-items: center; gap: var(--spacing-2); font-size: var(--font-size-sm); color: var(--text-secondary); }
        .origen-destino-arrow { color: var(--color-primary); }
        .tiempo-est { font-size: var(--font-size-sm); color: var(--text-secondary); }
        .tiempo-est span { font-weight: 500; color: var(--text-primary); }

        /* Estado badge */
        .estado-ruta-badge { display: inline-flex; align-items: center; gap: var(--spacing-2); padding: var(--spacing-1) var(--spacing-3); border-radius: var(--border-radius-sm); font-size: var(--font-size-xs); font-weight: 500; }
        .estado-ruta-badge.activa { background-color: var(--color-success-light); color: var(--color-success); }
        .estado-ruta-badge.inactiva { background-color: var(--color-danger-light); color: var(--color-danger); }
    </style>
    <div class="content-area">
                <div class="page-header">
                    <div class="page-header-top">
                        <div>
                            <h2 class="page-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                                Rutas
                            </h2>
                            <p class="page-subtitle">Gestiona las rutas de entrega</p>
                        </div>
                        <button class="btn-primary" id="btnCrearRuta">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Crear ruta
                        </button>
                    </div>
                </div>

                <!-- Stats -->
                <div class="ruta-stats">
                    <div class="ruta-stat-card">
                        <div class="ruta-stat-icon blue">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                        </div>
                        <div class="ruta-stat-info">
                            <div class="ruta-stat-label">Total rutas</div>
                            <div class="ruta-stat-value">5</div>
                        </div>
                    </div>
                    <div class="ruta-stat-card">
                        <div class="ruta-stat-icon green">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="ruta-stat-info">
                            <div class="ruta-stat-label">Activas</div>
                            <div class="ruta-stat-value" class="text-success">5</div>
                        </div>
                    </div>
                    <div class="ruta-stat-card">
                        <div class="ruta-stat-icon yellow">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                        <div class="ruta-stat-info">
                            <div class="ruta-stat-label">En uso</div>
                            <div class="ruta-stat-value" class="text-warning">3</div>
                        </div>
                    </div>
                    <div class="ruta-stat-card">
                        <div class="ruta-stat-icon purple">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div class="ruta-stat-info">
                            <div class="ruta-stat-label">Tiempo promedio</div>
                            <div class="ruta-stat-value" class="text-purple">8.2h</div>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="table-card">
                    <div class="table-card-header">
                        <div>
                            <h3 class="table-card-title">Listado de Rutas</h3>
                            <p class="table-card-subtitle">5 rutas encontradas</p>
                        </div>
                        <div class="search-box">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" placeholder="Buscar ruta, origen, destino...">
                        </div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Origen - Destino</th>
                                <th>Distancia</th>
                                <th>Tiempo est.</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="ruta-cell">
                                        <span class="ruta-nombre">RUTA-CDM-GDL</span>
                                        <span class="ruta-detalle">Ciudad de México - Guadalajara</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="origen-destino">
                                        <span>Ciudad de México</span>
                                        <span class="origen-destino-arrow">→</span>
                                        <span>Guadalajara</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path></svg>
                                        <span>540 km</span>
                                    </div>
                                </td>
                                <td class="tiempo-est"><span>6.5</span> horas</td>
                                <td><span class="estado-ruta-badge activa"><span style="width: 6px; height: 6px; background-color: var(--color-success); border-radius: 50%;"></span>Activa</span></td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ruta-cell">
                                        <span class="ruta-nombre">RUTA-MTY-CDM</span>
                                        <span class="ruta-detalle">Monterrey - Ciudad de México</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="origen-destino">
                                        <span>Monterrey</span>
                                        <span class="origen-destino-arrow">→</span>
                                        <span>Ciudad de México</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path></svg>
                                        <span>930 km</span>
                                    </div>
                                </td>
                                <td class="tiempo-est"><span>10</span> horas</td>
                                <td><span class="estado-ruta-badge activa"><span style="width: 6px; height: 6px; background-color: var(--color-success); border-radius: 50%;"></span>Activa</span></td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ruta-cell">
                                        <span class="ruta-nombre">RUTA-QRO-CUN</span>
                                        <span class="ruta-detalle">Querétaro - Cancún</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="origen-destino">
                                        <span>Querétaro</span>
                                        <span class="origen-destino-arrow">→</span>
                                        <span>Cancún</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path></svg>
                                        <span>1,650 km</span>
                                    </div>
                                </td>
                                <td class="tiempo-est"><span>18</span> horas</td>
                                <td><span class="estado-ruta-badge activa"><span style="width: 6px; height: 6px; background-color: var(--color-success); border-radius: 50%;"></span>Activa</span></td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ruta-cell">
                                        <span class="ruta-nombre">RUTA-GDL-PUE</span>
                                        <span class="ruta-detalle">Guadalajara - Puebla</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="origen-destino">
                                        <span>Guadalajara</span>
                                        <span class="origen-destino-arrow">→</span>
                                        <span>Puebla</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path></svg>
                                        <span>680 km</span>
                                    </div>
                                </td>
                                <td class="tiempo-est"><span>8</span> horas</td>
                                <td><span class="estado-ruta-badge activa"><span style="width: 6px; height: 6px; background-color: var(--color-success); border-radius: 50%;"></span>Activa</span></td>
                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ruta-cell">
                                        <span class="ruta-nombre">RUTA-CHI-PUE</span>
                                        <span class="ruta-detalle">Chihuahua - Puebla</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="origen-destino">
                                        <span>Chihuahua</span>
                                        <span class="origen-destino-arrow">→</span>
                                        <span>Puebla</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path></svg>
                                        <span>1,200 km</span>
                                    </div>
                                </td>
                                <td class="tiempo-est"><span>14</span> horas</td>
                                <td><span class="estado-ruta-badge activa"><span style="width: 6px; height: 6px; background-color: var(--color-success); border-radius: 50%;"></span>Activa</span></td>
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
                        Mostrando 5 de 5 rutas
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Crear Ruta -->
    <div class="modal-overlay hidden" id="modalCrearRuta">
        <div class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Crear ruta</h3>
                    <p class="modal-subtitle">Completa todos los campos</p>
                </div>
                <button class="modal-close" id="btnCerrarModal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                        Nombre de la ruta
                    </label>
                    <input type="text" class="form-input" placeholder="Ej: RUTA-CDM-GDL">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            Origen
                        </label>
                        <input type="text" class="form-input" placeholder="Ciudad de origen">
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            Destino
                        </label>
                        <input type="text" class="form-input" placeholder="Ciudad de destino">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><path d="M12 2l-7 7h4v8h6v-8h4l-7-7z"></path></svg>
                            Distancia (km)
                        </label>
                        <input type="number" class="form-input" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            Tiempo estimado (horas)
                        </label>
                        <input type="number" class="form-input" placeholder="0" step="0.5">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Estado de la ruta</label>
                    <div class="status-toggle">
                        <button class="status-option active">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Activa
                        </button>
                        <button class="status-option inactive">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            Inactiva
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" id="btnCancelar">Cancelar</button>
                <button class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                    Crear ruta
                </button>
            </div>
        </div>
    </div>
    <script>
                // Modal
        const btnCrearRuta = document.getElementById('btnCrearRuta');
        const modalCrearRuta = document.getElementById('modalCrearRuta');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');

        btnCrearRuta.addEventListener('click', () => modalCrearRuta.classList.remove('hidden'));
        btnCerrarModal.addEventListener('click', () => modalCrearRuta.classList.add('hidden'));
        btnCancelar.addEventListener('click', () => modalCrearRuta.classList.add('hidden'));
        modalCrearRuta.addEventListener('click', (e) => { if (e.target === modalCrearRuta) modalCrearRuta.classList.add('hidden'); });

        // Status toggle
        const statusOptions = document.querySelectorAll('.status-option');
        statusOptions.forEach(option => {
            option.addEventListener('click', function() {
                statusOptions.forEach(o => o.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
@endsection