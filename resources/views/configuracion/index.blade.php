@extends('layouts.app')

@section('title', 'Configuración - VEYLI')
@section('header-title', 'Panel Administrativo')

@section('content')
    <div class="page-header">
        <div class="page-header-top">
            <div>
                <h2 class="page-title">Configuración</h2>
                <p class="page-subtitle">Perfil, sistema y notificaciones en un solo lugar.</p>
            </div>
        </div>
    </div>

    <div class="settings-grid">
        <section class="settings-card" id="perfil">
            <div class="settings-card-head">
                <div>
                    <h3 class="settings-card-title">Perfil</h3>
                    <p class="settings-card-subtitle">Funciones básicas del perfil administrativo.</p>
                </div>
                <span class="settings-chip">Cuenta actual</span>
            </div>

            <form method="POST" action="{{ route('configuracion.profile') }}" class="settings-form split-actions" onsubmit="return confirm('¿Deseas actualizar tu perfil?')">
                @csrf
                @method('PUT')
                <div class="resource-form-grid resource-form-grid-single">
                    <div>
                        <label class="form-label">Nombre</label>
                        <input class="form-input" type="text" name="name" value="{{ old('name', data_get($apiUser, 'name')) }}" required>
                        @error('name') <div class="form-hint text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label">Correo</label>
                        <input class="form-input" type="email" name="email" value="{{ old('email', data_get($apiUser, 'email')) }}" required>
                        @error('email') <div class="form-hint text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="modal-footer modal-footer-wide">
                    <button type="button" class="btn-secondary" onclick="window.location='{{ route('dashboard') }}'">Cancelar</button>
                    <button type="submit" class="btn-primary">Guardar perfil</button>
                </div>
            </form>
        </section>

        <section class="settings-card" id="sistema">
            <div class="settings-card-head">
                <div>
                    <h3 class="settings-card-title">Sistema</h3>
                    <p class="settings-card-subtitle">Ajustes globales que sí afectan el comportamiento real.</p>
                </div>
                <span class="settings-chip">Persistente</span>
            </div>

            <form method="POST" action="{{ route('configuracion.system') }}" class="settings-form split-actions" onsubmit="return confirm('¿Quieres guardar los ajustes del sistema?')">
                @csrf
                @method('PUT')
                <div class="resource-form-grid">
                    <div>
                        <label class="form-label">Nombre del sistema</label>
                        <input class="form-input" type="text" name="company_name" value="{{ old('company_name', data_get($settingsPayload, 'company_name', 'VEYLI')) }}" required>
                        @error('company_name') <div class="form-hint text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label">Correo de soporte</label>
                        <input class="form-input" type="email" name="support_email" value="{{ old('support_email', data_get($settingsPayload, 'support_email')) }}">
                        @error('support_email') <div class="form-hint text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label">Teléfono de soporte</label>
                        <input class="form-input" type="text" name="support_phone" value="{{ old('support_phone', data_get($settingsPayload, 'support_phone')) }}">
                        @error('support_phone') <div class="form-hint text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label">Tiempo de sesión (minutos)</label>
                        <input class="form-input" type="number" min="15" max="1440" name="session_timeout_minutes" value="{{ old('session_timeout_minutes', data_get($settingsPayload, 'session_timeout_minutes', 60)) }}" required>
                        @error('session_timeout_minutes') <div class="form-hint text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="resource-form-span">
                        <div class="settings-inline-switches">
                            <label class="settings-switch">
                                <input type="checkbox" name="client_registration_enabled" value="1" @checked(old('client_registration_enabled', data_get($settingsPayload, 'client_registration_enabled', true)))>
                                <span class="settings-switch-track"><span class="settings-switch-thumb"></span></span>
                                <span class="settings-switch-copy">Permitir registro público de clientes</span>
                            </label>
                            <label class="settings-switch">
                                <input type="checkbox" name="maintenance_mode" value="1" @checked(old('maintenance_mode', data_get($settingsPayload, 'maintenance_mode', false)))>
                                <span class="settings-switch-track"><span class="settings-switch-thumb"></span></span>
                                <span class="settings-switch-copy">Modo mantenimiento</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer modal-footer-wide">
                    <button type="button" class="btn-secondary" onclick="window.location='{{ route('dashboard') }}'">Cancelar</button>
                    <button type="submit" class="btn-primary">Guardar sistema</button>
                </div>
            </form>
        </section>

        <section class="settings-card" id="notificaciones">
            <div class="settings-card-head">
                <div>
                    <h3 class="settings-card-title">Notificaciones</h3>
                    <p class="settings-card-subtitle">Controla lo que aparece en campana, alertas y flujo operativo.</p>
                </div>
                <span class="settings-chip">Operación</span>
            </div>

            <form method="POST" action="{{ route('configuracion.notifications') }}" class="settings-form split-actions" onsubmit="return confirm('¿Quieres actualizar las notificaciones?')">
                @csrf
                @method('PUT')
                <div class="settings-notification-grid">
                    <label class="settings-switch-card">
                        <input type="checkbox" name="notification_email_enabled" value="1" @checked(old('notification_email_enabled', data_get($settingsPayload, 'notification_email_enabled', true)))>
                        <span class="settings-switch-track"><span class="settings-switch-thumb"></span></span>
                        <strong>Correo</strong>
                        <small>Envía avisos por email.</small>
                    </label>
                    <label class="settings-switch-card">
                        <input type="checkbox" name="notification_push_enabled" value="1" @checked(old('notification_push_enabled', data_get($settingsPayload, 'notification_push_enabled', true)))>
                        <span class="settings-switch-track"><span class="settings-switch-thumb"></span></span>
                        <strong>Campana interna</strong>
                        <small>Muestra alertas en el header.</small>
                    </label>
                    <label class="settings-switch-card">
                        <input type="checkbox" name="notification_assignment_enabled" value="1" @checked(old('notification_assignment_enabled', data_get($settingsPayload, 'notification_assignment_enabled', true)))>
                        <span class="settings-switch-track"><span class="settings-switch-thumb"></span></span>
                        <strong>Asignaciones</strong>
                        <small>Notifica cambios de ruta, conductor y vehículo.</small>
                    </label>
                    <label class="settings-switch-card">
                        <input type="checkbox" name="notification_status_enabled" value="1" @checked(old('notification_status_enabled', data_get($settingsPayload, 'notification_status_enabled', true)))>
                        <span class="settings-switch-track"><span class="settings-switch-thumb"></span></span>
                        <strong>Estados</strong>
                        <small>Notifica entregas, retrasos y cambios críticos.</small>
                    </label>
                </div>

                <div class="modal-footer modal-footer-wide">
                    <button type="button" class="btn-secondary" onclick="window.location='{{ route('dashboard') }}'">Cancelar</button>
                    <button type="submit" class="btn-primary">Guardar notificaciones</button>
                </div>
            </form>
        </section>
    </div>
@endsection
