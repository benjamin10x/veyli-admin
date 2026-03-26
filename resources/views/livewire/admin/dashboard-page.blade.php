@php
    $summaryCards = [
        ['label' => 'Total envios', 'key' => 'total_packages', 'tone' => 'blue'],
        ['label' => 'Entregados', 'key' => 'delivered', 'tone' => 'green'],
        ['label' => 'En ruta', 'key' => 'in_route', 'tone' => 'yellow'],
        ['label' => 'Retrasados', 'key' => 'delayed', 'tone' => 'red'],
    ];

    if ($scope === 'admin') {
        $summaryCards[] = ['label' => 'Clientes', 'key' => 'clients', 'tone' => 'purple'];
        $summaryCards[] = ['label' => 'Conductores activos', 'key' => 'active_drivers', 'tone' => 'green'];
        $summaryCards[] = ['label' => 'Vehiculos disponibles', 'key' => 'available_vehicles', 'tone' => 'blue'];
        $summaryCards[] = ['label' => 'Rutas activas', 'key' => 'active_routes', 'tone' => 'yellow'];
    }

    $statusMax = max(1, (int) collect($statusBreakdown)->max('total'));
    $activityMax = max(1, (int) collect($activityTrend)->max('total'));
    $deliveryRate = data_get($totals, 'total_packages', 0) > 0
        ? round((data_get($totals, 'delivered', 0) / data_get($totals, 'total_packages', 1)) * 100)
        : 0;
    $activeLoad = data_get($totals, 'total_packages', 0) > 0
        ? round(((data_get($totals, 'pending', 0) + data_get($totals, 'in_route', 0) + data_get($totals, 'delayed', 0)) / data_get($totals, 'total_packages', 1)) * 100)
        : 0;
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
                <p class="page-subtitle">Indicadores visuales y actividad operativa alineados a tu base de datos.</p>
            </div>
        </div>
    </div>

    <div class="stats-grid dashboard-stats-grid">
        @foreach ($summaryCards as $card)
            <div class="stat-card">
                <div class="stat-icon {{ $card['tone'] }}">
                    @switch($card['key'])
                        @case('total_packages')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                            @break
                        @case('delivered')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            @break
                        @case('in_route')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polyline></svg>
                            @break
                        @case('delayed')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            @break
                        @case('clients')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            @break
                        @case('active_drivers')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                            @break
                        @case('available_vehicles')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            @break
                        @default
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 21 18 21 2 16 6 8 2 1 6"></polygon></svg>
                    @endswitch
                </div>
                <div class="stat-info">
                    <div class="stat-label">{{ $card['label'] }}</div>
                    <div class="stat-value">{{ number_format((int) data_get($totals, $card['key'], 0)) }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="cards-grid dashboard-cards-grid">
        <div class="feature-card dashboard-hero-card">
            <div class="feature-card-title">Resumen ejecutivo</div>
            <div class="feature-card-desc">
                {{ $scope === 'admin' ? 'Panorama general de envios, capacidad y desempeño operativo.' : 'Seguimiento rapido de tus envios recientes.' }}
            </div>

            <div class="dashboard-pill-grid">
                <div class="dashboard-pill">
                    <span class="dashboard-pill-label">Tasa de entrega</span>
                    <strong>{{ $deliveryRate }}%</strong>
                </div>
                <div class="dashboard-pill">
                    <span class="dashboard-pill-label">Carga activa</span>
                    <strong>{{ $activeLoad }}%</strong>
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

        <div class="feature-card">
            <div class="feature-card-title">Distribucion por estado</div>
            <div class="feature-card-desc">Volumen real de paquetes en cada etapa.</div>

            <div class="dashboard-bar-list">
                @forelse ($statusBreakdown as $status)
                    <div class="dashboard-bar-row">
                        <div class="dashboard-bar-label">{{ data_get($status, 'status') }}</div>
                        <div class="dashboard-bar-track">
                            <div
                                class="dashboard-bar-fill"
                                style="
                                    width: {{ max(6, (int) round((data_get($status, 'total', 0) / $statusMax) * 100)) }}%;
                                    background-color: {{ data_get($status, 'color', '#d4a84b') }};
                                "
                            ></div>
                        </div>
                        <div class="dashboard-bar-value">{{ data_get($status, 'total', 0) }}</div>
                    </div>
                @empty
                    <div class="dashboard-empty">Sin estados registrados para mostrar.</div>
                @endforelse
            </div>
        </div>

        <div class="activity-card">
            <div class="activity-card-title">{{ $scope === 'admin' ? 'Clientes con mas envios' : 'Actividad reciente' }}</div>
            <div class="activity-list">
                @if ($scope === 'admin')
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
                @else
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
                @endif
            </div>
        </div>
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
