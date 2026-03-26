@extends('layouts.auth')

@section('title', 'Registro - VEYLI')

@section('content')
   <div class="login-container">
        <!-- Left Side -->
        <div class="login-left">
            <img src="{{ asset('assets/images/logo.png') }}" alt="VEYLI Logo" class="login-logo">
            <h1 class="login-title">
                Gestión integral<br>
                de <span>mensajería</span><br>
                y logística
            </h1>
            <p class="login-subtitle">
                Plataforma unificada para la administración de rutas, envíos, conductores y clientes en tiempo real.
            </p>
            <div class="login-stats">
                <div class="login-stat">
                    <div class="login-stat-value">98%</div>
                    <div class="login-stat-label">Entregas puntuales</div>
                </div>
                <div class="login-stat">
                    <div class="login-stat-value">24/7</div>
                    <div class="login-stat-label">Monitoreo</div>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="login-right">
            <div class="login-form-container">
                <div class="login-form-header">
                    <div class="login-form-title-group">
                        <h2 class="login-form-title">Registro de Usuario</h2>
                        <p class="login-form-subtitle">Completa los campos requeridos para crear tu acceso</p>
                    </div>
                </div>

                @if (session('error'))
                    <div style="margin-bottom: 16px; background:#fee2e2; color:#991b1b; padding:12px 14px; border-radius:12px;">
                        {{ session('error') }}
                    </div>
                @endif

                <form class="login-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" class="form-input" name="name" placeholder="Nombre completo" value="{{ old('name') }}" required>
                        @error('name') <div style="color:#b91c1c; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-input" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                        @error('email') <div style="color:#b91c1c; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contraseña</label>
                        <div class="password-input-wrapper">
                            <input type="password" class="form-input" name="password" placeholder="••••••••" required>
                            <button type="button" class="password-toggle">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('password') <div style="color:#b91c1c; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirmar contraseña</label>
                        <div class="password-input-wrapper">
                            <input type="password" class="form-input" name="password_confirmation" placeholder="••••••••" required>
                            <button type="button" class="password-toggle">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-divider">Cuenta de cliente</div>
                    <div class="form-footer-text" style="text-align:left; margin-top:-8px;">
                        El registro público crea cuentas con rol <strong>cliente</strong> por defecto.
                    </div>

                    <div class="form-footer">
                        <p class="form-footer-text">
                            Al crear la cuenta aceptas los <a href="#">Términos de servicio</a> y la <a href="#">Política de privacidad</a>.
                        </p>

                        <button type="submit" class="btn-primary w-full justify-center">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                            Crear cuenta cliente
                        </button>

                        <p class="form-footer-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: var(--spacing-1);">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Form divider */
        .form-divider {
            text-align: center;
            font-size: var(--font-size-sm);
            font-weight: 500;
            color: var(--text-secondary);
            margin: var(--spacing-6) 0;
            position: relative;
        }

        .form-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: var(--border-color);
        }

        .form-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 1px;
            background-color: var(--bg-card);
        }
    </style>

    <script>
        // Password toggle functionality
        const passwordToggles = document.querySelectorAll('.password-toggle');
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.innerHTML = `
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    `;
                } else {
                    input.type = 'password';
                    this.innerHTML = `
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    `;
                }
            });
        });
    </script>
@endsection
