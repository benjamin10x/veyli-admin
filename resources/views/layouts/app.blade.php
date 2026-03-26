<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VEYLI')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/images/logo.png'])
    @livewireStyles
</head>
<body>
    @php
        $displayName = data_get($apiUser, 'name', 'Usuario VEYLI');
        $displayEmail = data_get($apiUser, 'email', 'usuario@veyli.com');
        $notifications = collect($apiNotifications ?? []);
        $initials = collect(explode(' ', $displayName))
            ->filter()
            ->take(2)
            ->map(fn ($segment) => strtoupper(substr($segment, 0, 1)))
            ->implode('');
    @endphp
    <div class="app-container">
        @include('components.sidebar')

        <main class="main-content">
            <header class="header">
                <div class="header-left">
                    <button class="menu-toggle" id="menuToggle" type="button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <h1 class="header-title">@yield('header-title', 'Panel Administrativo')</h1>
                </div>

                <div class="header-right">
                    <div class="header-dropdown">
                        <button class="header-icon" type="button" data-dropdown-trigger="notifications">
                            @if ($notifications->isNotEmpty())
                                <span class="badge">{{ min($notifications->count(), 9) }}</span>
                            @endif
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                        </button>

                        <div class="header-menu-panel" data-dropdown-panel="notifications">
                            <div class="header-menu-head">
                                <strong>Notificaciones</strong>
                                <span>{{ $notifications->count() }} recientes</span>
                            </div>

                            @forelse ($notifications as $notification)
                                <div class="header-menu-item">
                                    <span class="header-menu-dot {{ data_get($notification, 'tone', 'info') }}"></span>
                                    <div>
                                        <strong>{{ data_get($notification, 'title', 'Notificación') }}</strong>
                                        <span>{{ data_get($notification, 'message') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="header-menu-empty">No hay notificaciones nuevas.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="header-dropdown">
                        <button class="user-menu" type="button" data-dropdown-trigger="profile">
                            <div class="user-avatar">{{ $initials ?: 'VU' }}</div>
                            <span class="user-name">{{ $displayName }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>

                        <div class="header-menu-panel profile-panel" data-dropdown-panel="profile">
                            <div class="profile-panel-head">
                                <strong>{{ $displayName }}</strong>
                                <span>{{ $displayEmail }}</span>
                            </div>
                            <a href="{{ route('configuracion.index') }}#perfil" class="header-menu-link">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Mi perfil
                            </a>
                            <a href="{{ route('configuracion.index') }}" class="header-menu-link">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82"></path>
                                    <path d="M4.6 9A1.65 1.65 0 0 0 4.27 7.18"></path>
                                    <path d="M9 19.4A1.65 1.65 0 0 0 7.18 19.73"></path>
                                    <path d="M15 4.6A1.65 1.65 0 0 0 16.82 4.27"></path>
                                </svg>
                                Configuración
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="header-menu-link logout">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-area">
                @if (session('success'))
                    <div style="margin-bottom:16px; background:#dcfce7; color:#166534; padding:14px 16px; border-radius:12px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div style="margin-bottom:16px; background:#fee2e2; color:#991b1b; padding:14px 16px; border-radius:12px;">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (menuToggle) {
            menuToggle.addEventListener('click', function () {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function () {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }

        document.querySelectorAll('[data-dropdown-trigger]').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                const key = trigger.getAttribute('data-dropdown-trigger');
                const panel = document.querySelector('[data-dropdown-panel="' + key + '"]');
                document.querySelectorAll('[data-dropdown-panel]').forEach(function (item) {
                    if (item !== panel) {
                        item.classList.remove('active');
                    }
                });
                panel?.classList.toggle('active');
            });
        });

        document.addEventListener('click', function (event) {
            if (!event.target.closest('.header-dropdown')) {
                document.querySelectorAll('[data-dropdown-panel]').forEach(function (panel) {
                    panel.classList.remove('active');
                });
            }
        });
    </script>
    {{ $slot ?? '' }}

    @livewireScripts
</body>
</html>
