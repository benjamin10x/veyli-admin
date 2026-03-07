@extends('layouts.auth')

@section('title', 'Iniciar sesión - VEYLI')

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
                        <h2 class="login-form-title">Iniciar Sesión</h2>
                        <p class="login-form-subtitle">Ingresa tus credenciales para acceder al sistema</p>
                    </div>
                </div>

                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-input" name="email" placeholder="Correo electrónico" required>
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
                    </div>

                    <div class="form-footer">
                        <div class="form-options">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember" class="checkbox-input">
                                <span class="checkbox-mark"></span>
                                Recordarme
                            </label>
                            <a href="#" class="forgot-password-link">¿Olvidaste tu contraseña?</a>
                        </div>

                        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            Iniciar Sesión
                        </button>

                        <p class="form-footer-link">
                            ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Form options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-5);
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: var(--spacing-2);
            font-size: var(--font-size-sm);
            color: var(--text-secondary);
            cursor: pointer;
        }

        .checkbox-input {
            display: none;
        }

        .checkbox-mark {
            width: 16px;
            height: 16px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--bg-input);
            position: relative;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .checkbox-input:checked + .checkbox-mark {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .checkbox-input:checked + .checkbox-mark::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 5px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .forgot-password-link {
            font-size: var(--font-size-sm);
            color: var(--color-primary);
            text-decoration: none;
        }

        .forgot-password-link:hover {
            text-decoration: underline;
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