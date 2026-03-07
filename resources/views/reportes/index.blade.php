@extends('layouts.app')

@section('title', 'Dashboard - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
    <style>

        /* Stats cards */
        .report-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--spacing-4); margin-bottom: var(--spacing-6); }
        .report-stat-card { background-color: var(--bg-card); border-radius: var(--border-radius); padding: var(--spacing-5); display: flex; align-items: center; gap: var(--spacing-4); }
        .report-stat-icon { width: 48px; height: 48px; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; }
        .report-stat-icon.blue { background-color: var(--color-info-light); color: var(--color-info); }
        .report-stat-icon.green { background-color: var(--color-success-light); color: var(--color-success); }
        .report-stat-icon.yellow { background-color: var(--color-warning-light); color: var(--color-warning); }
        .report-stat-icon.purple { background-color: #f3e8ff; color: #9333ea; }
        .report-stat-info { flex: 1; }
        .report-stat-label { font-size: var(--font-size-sm); color: var(--text-secondary); }
        .report-stat-value { font-size: var(--font-size-2xl); font-weight: 700; color: var(--text-primary); }

        /* Report Layout */
        .report-layout { display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-6); }
        
        /* Report Form Card */
        .report-form-card { background-color: var(--bg-card); border-radius: var(--border-radius); padding: var(--spacing-6); box-shadow: var(--shadow-sm); }
        .report-form-header { display: flex; align-items: center; gap: var(--spacing-3); margin-bottom: var(--spacing-6); }
        .report-form-icon { width: 40px; height: 40px; border-radius: var(--border-radius); background-color: var(--color-primary); display: flex; align-items: center; justify-content: center; color: white; }
        .report-form-title { font-size: var(--font-size-lg); font-weight: 600; color: var(--text-primary); }
        .report-form-subtitle { font-size: var(--font-size-sm); color: var(--text-secondary); }

        /* Form sections */
        .form-section { margin-bottom: var(--spacing-6); }
        .form-section-title { font-size: var(--font-size-sm); font-weight: 600; color: var(--text-primary); margin-bottom: var(--spacing-3); display: flex; align-items: center; gap: var(--spacing-2); }
        .form-section-title svg { color: var(--color-primary); }

        /* Report type grid */
        .report-type-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--spacing-3); }
        .report-type-option { padding: var(--spacing-4); border: 2px solid var(--border-color); border-radius: var(--border-radius); background-color: var(--bg-card); cursor: pointer; transition: all 0.2s; text-align: left; }
        .report-type-option:hover { border-color: var(--color-primary-light); }
        .report-type-option.selected { border-color: var(--color-primary); background-color: rgba(212, 168, 75, 0.05); }
        .report-type-icon { width: 36px; height: 36px; border-radius: var(--border-radius-sm); display: flex; align-items: center; justify-content: center; margin-bottom: var(--spacing-3); }
        .report-type-icon.blue { background-color: var(--color-info-light); color: var(--color-info); }
        .report-type-icon.green { background-color: var(--color-success-light); color: var(--color-success); }
        .report-type-icon.yellow { background-color: var(--color-warning-light); color: var(--color-warning); }
        .report-type-icon.purple { background-color: #f3e8ff; color: #9333ea; }
        .report-type-name { font-size: var(--font-size-sm); font-weight: 600; color: var(--text-primary); margin-bottom: var(--spacing-1); }
        .report-type-desc { font-size: var(--font-size-xs); color: var(--text-muted); }

        /* Date range */
        .date-range { display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-4); }

        /* Export buttons */
        .export-buttons { display: flex; gap: var(--spacing-3); margin-top: var(--spacing-6); }
        .export-btn { flex: 1; padding: var(--spacing-3) var(--spacing-4); border: 1px solid var(--border-color); border-radius: var(--border-radius-sm); background-color: var(--bg-card); display: flex; align-items: center; justify-content: center; gap: var(--spacing-2); font-size: var(--font-size-sm); font-weight: 500; color: var(--text-secondary); transition: all 0.2s; }
        .export-btn:hover { border-color: var(--color-primary); color: var(--color-primary); background-color: rgba(212, 168, 75, 0.05); }
        .export-btn svg { width: 18px; height: 18px; }

        /* Preview Card */
        .preview-card { background-color: var(--bg-card); border-radius: var(--border-radius); padding: var(--spacing-6); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; }
        .preview-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--spacing-6); }
        .preview-title { font-size: var(--font-size-lg); font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: var(--spacing-3); }
        .preview-title svg { color: var(--color-primary); }
        .preview-badge { padding: var(--spacing-1) var(--spacing-3); background-color: var(--color-success-light); color: var(--color-success); border-radius: var(--border-radius-sm); font-size: var(--font-size-xs); font-weight: 500; }
        
        /* Preview content */
        .preview-content { flex: 1; background-color: var(--bg-main); border-radius: var(--border-radius); padding: var(--spacing-6); min-height: 400px; }
        .preview-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: var(--text-muted); text-align: center; }
        .preview-empty-icon { width: 80px; height: 80px; border-radius: 50%; background-color: var(--bg-card); display: flex; align-items: center; justify-content: center; margin-bottom: var(--spacing-4); color: var(--text-muted); }
        .preview-empty-title { font-size: var(--font-size-lg); font-weight: 600; color: var(--text-primary); margin-bottom: var(--spacing-2); }
        .preview-empty-text { font-size: var(--font-size-sm); color: var(--text-secondary); max-width: 280px; }

        /* Preview stats */
        .preview-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--spacing-4); margin-bottom: var(--spacing-6); }
        .preview-stat { background-color: var(--bg-card); border-radius: var(--border-radius-sm); padding: var(--spacing-4); text-align: center; }
        .preview-stat-value { font-size: var(--font-size-xl); font-weight: 700; color: var(--color-primary); margin-bottom: var(--spacing-1); }
        .preview-stat-label { font-size: var(--font-size-xs); color: var(--text-secondary); }

        /* Preview table */
        .preview-table { width: 100%; background-color: var(--bg-card); border-radius: var(--border-radius-sm); overflow: hidden; }
        .preview-table th, .preview-table td { padding: var(--spacing-3) var(--spacing-4); font-size: var(--font-size-sm); text-align: left; border-bottom: 1px solid var(--border-color); }
        .preview-table th { background-color: var(--bg-main); font-weight: 500; color: var(--text-secondary); }
        .preview-table td { color: var(--text-primary); }
        .preview-table tr:last-child td { border-bottom: none; }

        /* Generate button */
        .generate-btn { width: 100%; padding: var(--spacing-4); background-color: var(--color-primary); color: white; border-radius: var(--border-radius); font-size: var(--font-size-base); font-weight: 600; display: flex; align-items: center; justify-content: center; gap: var(--spacing-3); transition: background-color 0.2s; margin-top: var(--spacing-4); }
        .generate-btn:hover { background-color: var(--color-primary-dark); }

        @media (max-width: 1200px) { .report-layout { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { 
            .report-stats { grid-template-columns: repeat(2, 1fr); }
            .report-type-grid { grid-template-columns: 1fr; }
            .date-range { grid-template-columns: 1fr; }
        }
    </style>
    <div class="content-area">
                <!-- Breadcrumb -->
                <nav class="breadcrumb">
                    <a href="dashboard.html">Dashboard</a>
                    <span class="breadcrumb-separator">/</span>
                    <span>Reportes</span>
                </nav>

                <div class="page-header">
                    <div class="page-header-top">
                        <div>
                            <h2 class="page-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="svg-header-icon"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                Reportes
                            </h2>
                            <p class="page-subtitle">Genera y exporta reportes del sistema</p>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="report-stats">
                    <div class="report-stat-card">
                        <div class="report-stat-icon blue">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <div class="report-stat-info">
                            <div class="report-stat-label">Reportes disponibles</div>
                            <div class="report-stat-value">8</div>
                        </div>
                    </div>
                    <div class="report-stat-card">
                        <div class="report-stat-icon green">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="report-stat-info">
                            <div class="report-stat-label">Generados hoy</div>
                            <div class="report-stat-value" class="text-success">12</div>
                        </div>
                    </div>
                    <div class="report-stat-card">
                        <div class="report-stat-icon yellow">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div class="report-stat-info">
                            <div class="report-stat-label">Este mes</div>
                            <div class="report-stat-value" class="text-warning">156</div>
                        </div>
                    </div>
                    <div class="report-stat-card">
                        <div class="report-stat-icon purple">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        </div>
                        <div class="report-stat-info">
                            <div class="report-stat-label">Descargados</div>
                            <div class="report-stat-value" class="text-purple">89</div>
                        </div>
                    </div>
                </div>

                <!-- Report Layout -->
                <div class="report-layout">
                    <!-- Report Form -->
                    <div class="report-form-card">
                        <div class="report-form-header">
                            <div class="report-form-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                            </div>
                            <div>
                                <div class="report-form-title">Generar Reporte</div>
                                <div class="report-form-subtitle">Selecciona el tipo y configura los filtros</div>
                            </div>
                        </div>

                        <!-- Report Type -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                Tipo de reporte
                            </div>
                            <div class="report-type-grid">
                                <button class="report-type-option selected" data-type="envios">
                                    <div class="report-type-icon blue">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                    </div>
                                    <div class="report-type-name">Envíos</div>
                                    <div class="report-type-desc">Reporte de envíos y paquetes</div>
                                </button>
                                <button class="report-type-option" data-type="rutas">
                                    <div class="report-type-icon green">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                                    </div>
                                    <div class="report-type-name">Rutas</div>
                                    <div class="report-type-desc">Rendimiento de rutas</div>
                                </button>
                                <button class="report-type-option" data-type="conductores">
                                    <div class="report-type-icon yellow">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                    </div>
                                    <div class="report-type-name">Conductores</div>
                                    <div class="report-type-desc">Desempeño de conductores</div>
                                </button>
                                <button class="report-type-option" data-type="vehiculos">
                                    <div class="report-type-icon purple">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                    </div>
                                    <div class="report-type-name">Vehículos</div>
                                    <div class="report-type-desc">Estado de flota</div>
                                </button>
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                Rango de fechas
                            </div>
                            <div class="date-range">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label">Fecha inicio</label>
                                    <input type="date" class="form-input" value="2025-01-01">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label">Fecha fin</label>
                                    <input type="date" class="form-input" value="2025-01-31">
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>
                                Estado
                            </div>
                            <select class="form-select">
                                <option value="">Todos los estados</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="transito">En tránsito</option>
                                <option value="entregado">Entregado</option>
                                <option value="retrasado">Retrasado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>

                        <!-- Export Options -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                Exportar como
                            </div>
                            <div class="export-buttons">
                                <button class="export-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    PDF
                                </button>
                                <button class="export-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    Excel
                                </button>
                                <button class="export-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    CSV
                                </button>
                            </div>
                        </div>

                        <button class="generate-btn" id="btnGenerar">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                            Generar reporte
                        </button>
                    </div>

                    <!-- Preview -->
                    <div class="preview-card">
                        <div class="preview-header">
                            <div class="preview-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                Vista previa
                            </div>
                            <span class="preview-badge">Listo</span>
                        </div>

                        <div class="preview-content">
                            <!-- Preview Stats -->
                            <div class="preview-stats">
                                <div class="preview-stat">
                                    <div class="preview-stat-value">1,247</div>
                                    <div class="preview-stat-label">Total envíos</div>
                                </div>
                                <div class="preview-stat">
                                    <div class="preview-stat-value">89%</div>
                                    <div class="preview-stat-label">Entregados</div>
                                </div>
                                <div class="preview-stat">
                                    <div class="preview-stat-value">5.2h</div>
                                    <div class="preview-stat-label">Tiempo promedio</div>
                                </div>
                            </div>

                            <!-- Preview Table -->
                            <table class="preview-table">
                                <thead>
                                    <tr>
                                        <th>Tracking</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ENV-2025-001</td>
                                        <td>Juan Pérez</td>
                                        <td><span style="color: var(--color-success); font-weight: 500;">Entregado</span></td>
                                        <td>15/01/2025</td>
                                    </tr>
                                    <tr>
                                        <td>ENV-2025-002</td>
                                        <td>María García</td>
                                        <td><span style="color: var(--color-warning); font-weight: 500;">En tránsito</span></td>
                                        <td>16/01/2025</td>
                                    </tr>
                                    <tr>
                                        <td>ENV-2025-003</td>
                                        <td>Carlos López</td>
                                        <td><span style="color: var(--color-success); font-weight: 500;">Entregado</span></td>
                                        <td>17/01/2025</td>
                                    </tr>
                                    <tr>
                                        <td>ENV-2025-004</td>
                                        <td>Ana Martínez</td>
                                        <td><span style="color: var(--color-info); font-weight: 500;">Pendiente</span></td>
                                        <td>18/01/2025</td>
                                    </tr>
                                    <tr>
                                        <td>ENV-2025-005</td>
                                        <td>Pedro Sánchez</td>
                                        <td><span style="color: var(--color-success); font-weight: 500;">Entregado</span></td>
                                        <td>19/01/2025</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                        // Report type selection
        const reportTypeOptions = document.querySelectorAll('.report-type-option');
        reportTypeOptions.forEach(option => {
            option.addEventListener('click', function() {
                reportTypeOptions.forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
            </script>
@endsection