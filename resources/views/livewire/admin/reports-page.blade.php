@php
    $reportsCollection = collect($reports);
    $today = now()->toDateString();
    $currentMonth = now()->format('Y-m');
    $reportTypeOptions = [
        'envios' => ['label' => 'Envios', 'desc' => 'Volumen y estados de paquetes', 'tone' => 'blue'],
        'rutas' => ['label' => 'Rutas', 'desc' => 'Cobertura y carga por zona', 'tone' => 'green'],
        'conductores' => ['label' => 'Conductores', 'desc' => 'Asignaciones y actividad', 'tone' => 'yellow'],
        'vehiculos' => ['label' => 'Vehiculos', 'desc' => 'Disponibilidad de flota', 'tone' => 'purple'],
    ];
@endphp

<div>
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <span>Reportes</span>
    </nav>

    <div class="page-header">
        <div class="page-header-top">
            <div>
                <h2 class="page-title">Reportes</h2>
                <p class="page-subtitle">Genera, previsualiza y descarga reportes alineados a la operacion real.</p>
            </div>
        </div>
    </div>

    <div class="report-stats">
        <div class="report-stat-card">
            <div class="report-stat-icon blue" style="display:flex; align-items:center; justify-content:center; color: var(--color-info);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            </div>
            <div class="report-stat-info">
                <div class="report-stat-label">Reportes almacenados</div>
                <div class="report-stat-value">{{ $reportsCollection->count() }}</div>
            </div>
        </div>
        <div class="report-stat-card">
            <div class="report-stat-icon green" style="display:flex; align-items:center; justify-content:center; color: var(--color-success);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <div class="report-stat-info">
                <div class="report-stat-label">Generados hoy</div>
                <div class="report-stat-value">{{ $reportsCollection->filter(fn ($report) => str_starts_with((string) data_get($report, 'created_at', ''), $today))->count() }}</div>
            </div>
        </div>
        <div class="report-stat-card">
            <div class="report-stat-icon yellow" style="display:flex; align-items:center; justify-content:center; color: var(--color-warning);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <div class="report-stat-info">
                <div class="report-stat-label">Este mes</div>
                <div class="report-stat-value">{{ $reportsCollection->filter(fn ($report) => str_starts_with((string) data_get($report, 'created_at', ''), $currentMonth))->count() }}</div>
            </div>
        </div>
        <div class="report-stat-card">
            <div class="report-stat-icon purple" style="display:flex; align-items:center; justify-content:center; color: #9333ea;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            </div>
            <div class="report-stat-info">
                <div class="report-stat-label">Formatos listos</div>
                <div class="report-stat-value">3</div>
            </div>
        </div>
    </div>

    <div class="report-layout">
        <div class="report-form-card">
            <div class="report-form-header">
                <div class="report-form-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                </div>
                <div>
                    <div class="report-form-title">Generar reporte</div>
                    <div class="report-form-subtitle">Selecciona un enfoque, define fechas y descarga el resultado.</div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Tipo de reporte</div>
                <div class="report-type-grid">
                    @foreach ($reportTypeOptions as $value => $option)
                        <button
                            type="button"
                            class="report-type-option {{ $reportType === $value ? 'selected' : '' }}"
                            wire:click="$set('reportType', '{{ $value }}')"
                        >
                            <div class="report-type-icon {{ $option['tone'] }}" style="display:flex; align-items:center; justify-content:center; color:
                                {{ $option['tone'] === 'blue' ? 'var(--color-info)' : ($option['tone'] === 'green' ? 'var(--color-success)' : ($option['tone'] === 'yellow' ? 'var(--color-warning)' : '#9333ea')) }};">
                                @if ($value === 'envios')
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                @elseif ($value === 'rutas')
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                                @elseif ($value === 'conductores')
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle></svg>
                                @else
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                @endif
                            </div>
                            <div class="report-type-name">{{ $option['label'] }}</div>
                            <div class="report-type-desc">{{ $option['desc'] }}</div>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Rango de fechas</div>
                <div class="date-range">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Fecha inicio</label>
                        <input type="date" wire:model.live="startDate" class="form-input">
                        @error('startDate') <div class="form-hint text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Fecha fin</label>
                        <input type="date" wire:model.live="endDate" class="form-input">
                        @error('endDate') <div class="form-hint text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Resumen del filtro</div>
                <div class="report-filter-box">
                    <div><strong>Tipo:</strong> {{ data_get($reportTypeOptions, $reportType.'.label', strtoupper($reportType)) }}</div>
                    <div><strong>Periodo:</strong> {{ $startDate }} a {{ $endDate }}</div>
                    <div><strong>Total envios en vista:</strong> {{ data_get($summary, 'total_packages', 0) }}</div>
                </div>
            </div>

            <button class="generate-btn" type="button" wire:click="generate">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                    <line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                Generar reporte
            </button>

            <div class="export-buttons">
                <a
                    class="export-btn"
                    href="{{ route('reportes.export', ['format' => 'pdf', 'start_date' => $startDate, 'end_date' => $endDate, 'report_type' => $reportType]) }}"
                >
                    PDF
                </a>
                <a
                    class="export-btn"
                    href="{{ route('reportes.export', ['format' => 'excel', 'start_date' => $startDate, 'end_date' => $endDate, 'report_type' => $reportType]) }}"
                >
                    Excel
                </a>
                <a
                    class="export-btn"
                    href="{{ route('reportes.export', ['format' => 'csv', 'start_date' => $startDate, 'end_date' => $endDate, 'report_type' => $reportType]) }}"
                >
                    CSV
                </a>
            </div>
        </div>

        <div class="preview-card">
            <div class="preview-header">
                <div class="preview-title">Vista previa</div>
                <span class="preview-badge">Actualizada</span>
            </div>

            <div class="preview-content">
                <div class="preview-stats">
                    <div class="preview-stat">
                        <div class="preview-stat-value">{{ data_get($summary, 'total_packages', 0) }}</div>
                        <div class="preview-stat-label">Total envios</div>
                    </div>
                    <div class="preview-stat">
                        <div class="preview-stat-value">{{ data_get($summary, 'delivered', 0) }}</div>
                        <div class="preview-stat-label">Entregados</div>
                    </div>
                    <div class="preview-stat">
                        <div class="preview-stat-value">{{ data_get($summary, 'in_route', 0) }}</div>
                        <div class="preview-stat-label">En ruta</div>
                    </div>
                </div>

                <table class="preview-table">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Peso visual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (data_get($summary, 'by_status', []) as $row)
                            <tr>
                                <td>{{ data_get($row, 'status') }}</td>
                                <td>{{ data_get($row, 'total') }}</td>
                                <td>{{ data_get($row, 'total') }} registros</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Sin datos para el rango seleccionado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-card" style="margin-top: 24px;">
        <div class="table-card-header">
            <div>
                <h3 class="table-card-title">Reportes generados</h3>
                <p class="table-card-subtitle">{{ $reportsCollection->count() }} reportes almacenados en historial</p>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Rango</th>
                    <th>Usuario</th>
                    <th>Creado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr>
                        <td>{{ str((string) data_get($report, 'report_type'))->replace('_', ' ')->title() }}</td>
                        <td>{{ data_get($report, 'start_date') }} a {{ data_get($report, 'end_date') }}</td>
                        <td>{{ data_get($report, 'user.name') }}</td>
                        <td>{{ substr((string) data_get($report, 'created_at', ''), 0, 16) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:24px;">No hay reportes generados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
