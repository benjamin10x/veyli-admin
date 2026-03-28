@php
    $summaryCards = [
        ['label' => 'Total envios', 'key' => 'total_packages', 'tone' => 'blue'],
        ['label' => 'Entregados', 'key' => 'delivered', 'tone' => 'green'],
        ['label' => 'En ruta', 'key' => 'in_route', 'tone' => 'yellow'],
        ['label' => 'Retrasados', 'key' => 'delayed', 'tone' => 'red'],
        ['label' => 'Creados hoy', 'value' => data_get($todayMetrics, 'created_today', 0), 'tone' => 'purple'],
        ['label' => 'Entregados hoy', 'value' => data_get($todayMetrics, 'delivered_today', 0), 'tone' => 'green'],
    ];

    if ($scope === 'admin') {
        $summaryCards[] = ['label' => 'Clientes', 'key' => 'clients', 'tone' => 'purple'];
        $summaryCards[] = ['label' => 'Conductores activos', 'key' => 'active_drivers', 'tone' => 'green'];
        $summaryCards[] = ['label' => 'Vehiculos disponibles', 'key' => 'available_vehicles', 'tone' => 'blue'];
        $summaryCards[] = ['label' => 'Rutas activas', 'key' => 'active_routes', 'tone' => 'yellow'];
    }

    $statusMax = max(1, (int) collect($statusBreakdown)->max('total'));
    $activityMax = max(1, (int) collect($activityTrend)->max('total'));
    $health = $scope === 'admin' ? $operationalHealth : $portfolioHealth;

    $formatPercentage = function ($value) {
        $formatted = number_format((float) $value, 1, '.', '');
        $formatted = rtrim(rtrim($formatted, '0'), '.');

        return $formatted.'%';
    };

    $buildGradient = function ($segments) {
        $segments = collect($segments)
            ->filter(fn ($segment) => (float) data_get($segment, 'percentage', 0) > 0)
            ->values();

        if ($segments->isEmpty()) {
            return '#e5e7eb 0% 100%';
        }

        $cursor = 0;
        $parts = [];

        foreach ($segments as $index => $segment) {
            $start = round($cursor, 1);
            $cursor = $index === $segments->count() - 1
                ? 100
                : min(100, round($cursor + (float) data_get($segment, 'percentage', 0), 1));

            $parts[] = sprintf(
                '%s %s%% %s%%',
                data_get($segment, 'color', '#d4a84b'),
                $start,
                $cursor
            );
        }

        return implode(', ', $parts);
    };

    $statusSegments = collect($statusBreakdown)
        ->filter(fn ($segment) => (int) data_get($segment, 'total', 0) > 0)
        ->values()
        ->all();

    $serviceSegments = collect([
        [
            'label' => 'Entregados',
            'total' => (int) data_get($totals, 'delivered', 0),
            'percentage' => (float) data_get($health, 'delivery_rate', 0),
            'color' => '#22c55e',
        ],
        [
            'label' => 'Carga activa',
            'total' => (int) data_get($totals, 'pending', 0) + (int) data_get($totals, 'in_route', 0),
            'percentage' => (float) data_get($health, 'active_load', 0),
            'color' => '#d4a84b',
        ],
        [
            'label' => 'Incidencias',
            'total' => (int) data_get($totals, 'delayed', 0) + (int) data_get($totals, 'cancelled', 0),
            'percentage' => max(
                0,
                100 - ((float) data_get($health, 'delivery_rate', 0) + (float) data_get($health, 'active_load', 0))
            ),
            'color' => '#ef4444',
        ],
    ])->filter(fn ($segment) => (int) data_get($segment, 'total', 0) > 0)->values()->all();

    $eventPalette = ['#1e3a4a', '#d4a84b', '#22c55e', '#3b82f6', '#f59e0b', '#ef4444'];
    $eventSegments = collect($eventTypeBreakdown)
        ->values()
        ->map(fn ($segment, $index) => array_merge($segment, ['color' => $eventPalette[$index % count($eventPalette)]]))
        ->all();

    $attentionCards = [
        ['label' => 'Retrasados', 'value' => data_get($attentionMetrics, 'delayed', 0), 'tone' => 'warning'],
        ['label' => 'Vencidos', 'value' => data_get($attentionMetrics, 'overdue', 0), 'tone' => 'danger'],
    ];

    if ($scope === 'admin') {
        $attentionCards[] = ['label' => 'Cancelados', 'value' => data_get($attentionMetrics, 'cancelled', 0), 'tone' => 'muted'];
    } else {
        $attentionCards[] = ['label' => 'Atencion requerida', 'value' => data_get($portfolioHealth, 'attention_required', 0), 'tone' => 'muted'];
    }

    $activityTotal = (int) data_get($activityInsights, 'total_last_days', 0);
    $activityAverage = data_get($activityInsights, 'average_daily', 0);
    $peakDayLabel = data_get($activityInsights, 'peak_day.label', 'Sin pico');
    $peakDayTotal = (int) data_get($activityInsights, 'peak_day.total', 0);
@endphp

<div>
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <span>Panel operativo</span>
    </nav>

    <div class="page-header">
        <div class="page-header-top">
            <div>
                <h2 class="page-title">Panel Administrativo</h2>
                <p class="page-subtitle">KPIs, graficas y senales operativas conectadas a los datos reales del sistema.</p>
            </div>
        </div>
    </div>

    <div class="stats-grid dashboard-stats-grid dashboard-stats-grid-extended">
        @foreach ($summaryCards as $card)
            <div class="stat-card">
                <div class="stat-icon {{ $card['tone'] }}">
                    @switch($card['label'])
                        @case('Total envios')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                            @break
                        @case('Entregados')
                        @case('Entregados hoy')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            @break
                        @case('En ruta')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polyline></svg>
                            @break
                        @case('Retrasados')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            @break
                        @case('Clientes')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            @break
                        @case('Conductores activos')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                            @break
                        @case('Vehiculos disponibles')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            @break
                        @default
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20"></path><path d="M2 12h20"></path></svg>
                    @endswitch
                </div>
                <div class="stat-info">
                    <div class="stat-label">{{ $card['label'] }}</div>
                    <div class="stat-value">{{ number_format((int) ($card['value'] ?? data_get($totals, $card['key'], 0))) }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="cards-grid dashboard-spotlight-grid">
        <div class="feature-card dashboard-hero-card dashboard-hero-card-large">
            <div class="dashboard-section-head">
                <div>
                    <div class="feature-card-title">Resumen ejecutivo</div>
                    <div class="feature-card-desc">{{ $scope === 'admin' ? 'Lectura rapida del desempeno logistico y el ritmo de operacion.' : 'Panorama actual de tus envios y su avance.' }}</div>
                </div>
                <span class="dashboard-head-chip">{{ $scope === 'admin' ? 'Vista admin' : 'Vista cliente' }}</span>
            </div>

            <div class="dashboard-hero-layout">
                <div class="dashboard-gauge-card">
                    <div class="dashboard-gauge" style="--value: {{ min(100, max(0, (float) data_get($health, 'delivery_rate', 0))) }};">
                        <div class="dashboard-gauge-inner">
                            <strong>{{ $formatPercentage(data_get($health, 'delivery_rate', 0)) }}</strong>
                            <span>Tasa de entrega</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-pill-grid dashboard-pill-grid-wide">
                    <div class="dashboard-pill">
                        <span class="dashboard-pill-label">Carga activa</span>
                        <strong>{{ $formatPercentage(data_get($health, 'active_load', 0)) }}</strong>
                        <small>Paquetes pendientes o en movimiento.</small>
                    </div>
                    <div class="dashboard-pill">
                        <span class="dashboard-pill-label">Promedio diario</span>
                        <strong>{{ $activityAverage }}</strong>
                        <small>Envios registrados por dia en la ultima semana.</small>
                    </div>
                    <div class="dashboard-pill">
                        <span class="dashboard-pill-label">Pico semanal</span>
                        <strong>{{ $peakDayTotal }}</strong>
                        <small>{{ $peakDayLabel }}</small>
                    </div>
                    <div class="dashboard-pill">
                        <span class="dashboard-pill-label">Acumulado 7 dias</span>
                        <strong>{{ number_format($activityTotal) }}</strong>
                        <small>Volumen reciente consolidado.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="feature-card dashboard-hero-card">
            <div class="dashboard-section-head">
                <div>
                    <div class="feature-card-title">Ritmo diario</div>
                    <div class="feature-card-desc">Movimiento operativo y tendencia de carga reciente.</div>
                </div>
            </div>

            <div class="dashboard-today-grid">
                <div class="dashboard-kpi-tile">
                    <span>Creados hoy</span>
                    <strong>{{ number_format((int) data_get($todayMetrics, 'created_today', 0)) }}</strong>
                </div>
                <div class="dashboard-kpi-tile">
                    <span>Entregados hoy</span>
                    <strong>{{ number_format((int) data_get($todayMetrics, 'delivered_today', 0)) }}</strong>
                </div>
            </div>

            <div class="dashboard-mini-chart">
                @foreach ($activityTrend as $day)
                    <div class="dashboard-mini-col">
                        <span class="dashboard-mini-value">{{ data_get($day, 'total', 0) }}</span>
                        <div class="dashboard-mini-bar-shell">
                            <div class="dashboard-mini-bar" style="height: {{ max(8, (int) round((data_get($day, 'total', 0) / $activityMax) * 100)) }}%;"></div>
                        </div>
                        <span class="dashboard-mini-label">{{ data_get($day, 'label') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="feature-card dashboard-attention-card">
            <div class="dashboard-section-head">
                <div>
                    <div class="feature-card-title">Centro de atencion</div>
                    <div class="feature-card-desc">Lo que necesita seguimiento directo del equipo.</div>
                </div>
            </div>

            <div class="dashboard-attention-grid">
                @foreach ($attentionCards as $item)
                    <div class="dashboard-attention-item {{ $item['tone'] }}">
                        <span>{{ $item['label'] }}</span>
                        <strong>{{ number_format((int) $item['value']) }}</strong>
                    </div>
                @endforeach
            </div>

            <div class="dashboard-attention-total">
                <span>Total bajo observacion</span>
                <strong>{{ number_format((int) data_get($attentionMetrics, 'attention_total', 0)) }}</strong>
            </div>
        </div>
    </div>

    <div class="cards-grid dashboard-analytics-grid">
        <div class="feature-card dashboard-chart-card">
            <div class="dashboard-section-head">
                <div>
                    <div class="feature-card-title">Distribucion por estado</div>
                    <div class="feature-card-desc">Composicion actual del portafolio de envios.</div>
                </div>
            </div>

            <div class="dashboard-donut-layout">
                <div class="dashboard-donut" style="--chart: {{ $buildGradient($statusSegments) }};">
                    <div class="dashboard-donut-inner">
                        <strong>{{ number_format((int) data_get($totals, 'total_packages', 0)) }}</strong>
                        <span>Total envios</span>
                    </div>
                </div>

                <div class="dashboard-donut-legend">
                    @forelse ($statusSegments as $segment)
                        <div class="dashboard-legend-item">
                            <span class="dashboard-legend-dot" style="background-color: {{ data_get($segment, 'color', '#d4a84b') }}"></span>
                            <div>
                                <strong>{{ data_get($segment, 'status') }}</strong>
                                <span>{{ data_get($segment, 'total') }} · {{ $formatPercentage(data_get($segment, 'percentage', 0)) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="dashboard-empty">Sin estados registrados para mostrar.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="feature-card dashboard-chart-card">
            <div class="dashboard-section-head">
                <div>
                    <div class="feature-card-title">Salud del flujo</div>
                    <div class="feature-card-desc">Balance entre entregas, carga activa e incidencias.</div>
                </div>
            </div>

            <div class="dashboard-donut-layout">
                <div class="dashboard-donut dashboard-donut-alt" style="--chart: {{ $buildGradient($serviceSegments) }};">
                    <div class="dashboard-donut-inner">
                        <strong>{{ $formatPercentage(data_get($health, 'delivery_rate', 0)) }}</strong>
                        <span>Entrega efectiva</span>
                    </div>
                </div>

                <div class="dashboard-donut-legend">
                    @forelse ($serviceSegments as $segment)
                        <div class="dashboard-legend-item">
                            <span class="dashboard-legend-dot" style="background-color: {{ data_get($segment, 'color', '#d4a84b') }}"></span>
                            <div>
                                <strong>{{ data_get($segment, 'label') }}</strong>
                                <span>{{ data_get($segment, 'total') }} · {{ $formatPercentage(data_get($segment, 'percentage', 0)) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="dashboard-empty">Sin datos suficientes para calcular salud operativa.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="feature-card dashboard-chart-card">
            <div class="dashboard-section-head">
                <div>
                    <div class="feature-card-title">{{ $scope === 'admin' ? 'Mix de eventos' : 'Tu actividad reciente' }}</div>
                    <div class="feature-card-desc">{{ $scope === 'admin' ? 'Tipos de eventos que mas se repiten en la bitacora.' : 'Categorias de actividad relacionadas con tus envios.' }}</div>
                </div>
            </div>

            <div class="dashboard-donut-layout">
                <div class="dashboard-donut dashboard-donut-muted" style="--chart: {{ $buildGradient($eventSegments) }};">
                    <div class="dashboard-donut-inner">
                        <strong>{{ count($eventSegments) }}</strong>
                        <span>Tipos activos</span>
                    </div>
                </div>

                <div class="dashboard-donut-legend">
                    @forelse ($eventSegments as $segment)
                        <div class="dashboard-legend-item">
                            <span class="dashboard-legend-dot" style="background-color: {{ data_get($segment, 'color', '#1e3a4a') }}"></span>
                            <div>
                                <strong>{{ data_get($segment, 'label') }}</strong>
                                <span>{{ data_get($segment, 'total') }} · {{ $formatPercentage(data_get($segment, 'percentage', 0)) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="dashboard-empty">Sin eventos suficientes para graficar.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="cards-grid dashboard-operations-grid">
        @if ($scope === 'admin')
            <div class="feature-card dashboard-capacity-card">
                <div class="dashboard-section-head">
                    <div>
                        <div class="feature-card-title">Capacidad operativa</div>
                        <div class="feature-card-desc">Disponibilidad del ecosistema logistico en tiempo real.</div>
                    </div>
                </div>

                <div class="dashboard-capacity-list">
                    <div class="dashboard-capacity-item">
                        <div class="dashboard-capacity-head">
                            <strong>Conductores</strong>
                            <span>{{ data_get($capacityBreakdown, 'drivers.active', 0) }}/{{ data_get($capacityBreakdown, 'drivers.total', 0) }}</span>
                        </div>
                        <div class="dashboard-capacity-track">
                            <div class="dashboard-capacity-fill blue" style="width: {{ min(100, max(0, (float) data_get($capacityBreakdown, 'drivers.utilization_rate', 0))) }}%;"></div>
                        </div>
                    </div>
                    <div class="dashboard-capacity-item">
                        <div class="dashboard-capacity-head">
                            <strong>Vehiculos</strong>
                            <span>{{ data_get($capacityBreakdown, 'vehicles.available', 0) }}/{{ data_get($capacityBreakdown, 'vehicles.total', 0) }}</span>
                        </div>
                        <div class="dashboard-capacity-track">
                            <div class="dashboard-capacity-fill green" style="width: {{ min(100, max(0, (float) data_get($capacityBreakdown, 'vehicles.availability_rate', 0))) }}%;"></div>
                        </div>
                    </div>
                    <div class="dashboard-capacity-item">
                        <div class="dashboard-capacity-head">
                            <strong>Rutas</strong>
                            <span>{{ data_get($capacityBreakdown, 'routes.active', 0) }}/{{ data_get($capacityBreakdown, 'routes.total', 0) }}</span>
                        </div>
                        <div class="dashboard-capacity-track">
                            <div class="dashboard-capacity-fill yellow" style="width: {{ min(100, max(0, (float) data_get($capacityBreakdown, 'routes.coverage_rate', 0))) }}%;"></div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-health-grid">
                    <div class="dashboard-health-item">
                        <span>Retraso</span>
                        <strong>{{ $formatPercentage(data_get($operationalHealth, 'delay_rate', 0)) }}</strong>
                    </div>
                    <div class="dashboard-health-item">
                        <span>Cancelacion</span>
                        <strong>{{ $formatPercentage(data_get($operationalHealth, 'cancellation_rate', 0)) }}</strong>
                    </div>
                </div>
            </div>

            <div class="activity-card">
                <div class="activity-card-title">Clientes con mas envios</div>
                <div class="activity-list">
                    @forelse ($topClients as $client)
                        <div class="activity-item">
                            <div class="activity-icon blue">{{ strtoupper(substr((string) data_get($client, 'name', 'C'), 0, 1)) }}</div>
                            <div class="activity-content">
                                <div class="activity-text">{{ data_get($client, 'name') }}</div>
                                <div class="activity-time">{{ data_get($client, 'email') }} · {{ data_get($client, 'total_packages') }} envios</div>
                            </div>
                        </div>
                    @empty
                        <div class="dashboard-empty">No hay clientes para rankear.</div>
                    @endforelse
                </div>
            </div>
        @else
            <div class="activity-card">
                <div class="activity-card-title">Actividad reciente</div>
                <div class="activity-list">
                    @forelse ($latestEvents as $event)
                        <div class="activity-item">
                            <div class="activity-icon green">{{ strtoupper(substr((string) data_get($event, 'event_type', 'E'), 0, 1)) }}</div>
                            <div class="activity-content">
                                <div class="activity-text">{{ data_get($event, 'description') }}</div>
                                <div class="activity-time">{{ data_get($event, 'tracking_code') }} · {{ substr((string) data_get($event, 'created_at', ''), 0, 16) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="dashboard-empty">Sin actividad reciente.</div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>

    <div class="table-card" style="margin-bottom: 20px;">
        <div class="table-card-header">
            <div>
                <h3 class="table-card-title">Envios recientes</h3>
                <p class="table-card-subtitle">Ultimos movimientos registrados en plataforma</p>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Tracking</th>
                    <th>Cliente</th>
                    <th>Destino</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentPackages as $package)
                    <tr>
                        <td>{{ data_get($package, 'tracking_code') }}</td>
                        <td>{{ data_get($package, 'client.email', '—') }}</td>
                        <td>{{ data_get($package, 'destination_address') }}</td>
                        <td>{{ data_get($package, 'status.name', 'Sin estado') }}</td>
                        <td>{{ substr((string) data_get($package, 'registered_at', ''), 0, 16) ?: '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:24px;">No hay actividad reciente.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($scope === 'admin')
        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <h3 class="table-card-title">Bitacora operativa</h3>
                    <p class="table-card-subtitle">Eventos recientes guardados por la API</p>
                </div>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tracking</th>
                        <th>Evento</th>
                        <th>Detalle</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestEvents as $event)
                        <tr>
                            <td>{{ data_get($event, 'tracking_code') }}</td>
                            <td>{{ str((string) data_get($event, 'event_type', 'evento'))->replace('_', ' ')->title() }}</td>
                            <td>{{ data_get($event, 'description') }}</td>
                            <td>{{ data_get($event, 'user_name') }}</td>
                            <td>{{ substr((string) data_get($event, 'created_at', ''), 0, 16) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:24px;">Sin eventos operativos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
