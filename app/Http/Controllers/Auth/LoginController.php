<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ApiException;
use App\Exceptions\ApiValidationException;
use App\Http\Controllers\Controller;
use App\Services\AuthApiService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (session()->has('api_token')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request, AuthApiService $auth)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $response = $auth->login($credentials['email'], $credentials['password']);
        } catch (ApiValidationException $exception) {
            return back()->withInput()->withErrors($exception->errors());
        } catch (ApiException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        session([
            'api_token' => data_get($response, 'data.tokens.access_token'),
            'api_refresh_token' => data_get($response, 'data.tokens.refresh_token'),
            'api_user' => data_get($response, 'data.user'),
        ]);

        $permissions = data_get($response, 'data.user.permissions', []);
        if (data_get($response, 'data.user.role') === 'cliente' || !in_array('*', $permissions, true) && !in_array('dashboard.view', $permissions, true)) {
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Esta cuenta no tiene acceso al panel administrativo.');
        }

        return redirect()->route('dashboard');
    }

    public function showRegister()
    {
        if (session()->has('api_token')) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request, AuthApiService $auth)
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $segments = preg_split('/\s+/', trim($payload['name']), 2) ?: [];
        $firstName = $segments[0] ?? 'Cliente';
        $lastName = $segments[1] ?? ($segments[0] ?? 'VEYLI');

        try {
            $auth->registerClient(
                $firstName,
                $lastName,
                $payload['email'],
                $payload['password'],
            );
        } catch (ApiValidationException $exception) {
            return back()->withInput()->withErrors($exception->errors());
        } catch (ApiException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->route('login')->with('success', 'Cuenta cliente creada correctamente.');
    }

    public function logout()
    {
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
