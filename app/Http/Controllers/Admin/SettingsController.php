<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Exceptions\ApiValidationException;
use App\Http\Controllers\Controller;
use App\Services\AuthApiService;
use App\Services\SettingsApiService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show(SettingsApiService $settings)
    {
        try {
            $payload = $settings->get();
        } catch (ApiException $exception) {
            return redirect()->route('dashboard')->with('error', $exception->getMessage());
        }

        return view('configuracion.index', [
            'settingsPayload' => data_get($payload, 'data', []),
        ]);
    }

    public function updateProfile(Request $request, AuthApiService $auth)
    {
        $payload = $request->validate(
            [
                'name' => ['required', 'string', 'min:2', 'max:150'],
                'email' => ['required', 'email'],
            ],
            $this->validationMessages(),
            $this->validationAttributes([
                'name' => 'Nombre',
                'email' => 'Correo electrónico',
            ]),
        );

        try {
            $response = $auth->updateProfile($payload);
            session()->put('api_user', data_get($response, 'data.user', session('api_user')));
        } catch (ApiValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput();
        } catch (ApiException $exception) {
            return back()->with('error', $exception->getMessage())->withInput();
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function updateSystem(Request $request, SettingsApiService $settings)
    {
        $payload = $request->validate(
            [
                'company_name' => ['required', 'string', 'min:2', 'max:150'],
                'support_email' => ['nullable', 'email'],
                'support_phone' => ['nullable', 'string', 'max:50'],
                'session_timeout_minutes' => ['required', 'integer', 'min:15', 'max:1440'],
                'client_registration_enabled' => ['nullable', 'boolean'],
                'maintenance_mode' => ['nullable', 'boolean'],
            ],
            $this->validationMessages(),
            $this->validationAttributes([
                'company_name' => 'Nombre de la empresa',
                'support_email' => 'Correo de soporte',
                'support_phone' => 'Teléfono de soporte',
                'session_timeout_minutes' => 'Tiempo de sesión',
                'client_registration_enabled' => 'Registro de clientes',
                'maintenance_mode' => 'Modo mantenimiento',
            ]),
        );

        $payload['client_registration_enabled'] = $request->boolean('client_registration_enabled');
        $payload['maintenance_mode'] = $request->boolean('maintenance_mode');

        try {
            $settings->updateSystem($payload);
        } catch (ApiValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput();
        } catch (ApiException $exception) {
            return back()->with('error', $exception->getMessage())->withInput();
        }

        return back()->with('success', 'Ajustes del sistema actualizados.');
    }

    public function updateNotifications(Request $request, SettingsApiService $settings)
    {
        $payload = [
            'notification_email_enabled' => $request->boolean('notification_email_enabled'),
            'notification_push_enabled' => $request->boolean('notification_push_enabled'),
            'notification_assignment_enabled' => $request->boolean('notification_assignment_enabled'),
            'notification_status_enabled' => $request->boolean('notification_status_enabled'),
        ];

        try {
            $settings->updateNotifications($payload);
        } catch (ApiValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput();
        } catch (ApiException $exception) {
            return back()->with('error', $exception->getMessage())->withInput();
        }

        return back()->with('success', 'Preferencias de notificaciones actualizadas.');
    }
}
