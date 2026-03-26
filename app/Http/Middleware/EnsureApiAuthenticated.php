<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Services\AuthApiService;
use App\Services\SettingsApiService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EnsureApiAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        try {
            $me = app(AuthApiService::class)->me();
            Session::put('api_user', data_get($me, 'data.user'));
            $notifications = app(SettingsApiService::class)->notificationFeed();
            Session::put('api_notifications', data_get($notifications, 'data.items', []));
        } catch (ApiException) {
            Session::forget(['api_token', 'api_refresh_token', 'api_user', 'api_notifications']);

            return redirect()->route('login')->with('error', 'Tu sesión expiró. Inicia sesión nuevamente.');
        }

        return $next($request);
    }
}
