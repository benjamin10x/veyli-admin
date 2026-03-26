<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EnsurePermissionAccess
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $user = Session::get('api_user', []);
        $granted = collect(data_get($user, 'permissions', []));

        if ($granted->contains('*')) {
            return $next($request);
        }

        $allowed = collect($permissions)
            ->filter()
            ->every(fn (string $permission) => $granted->contains($permission));

        if (!$allowed) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a este módulo.');
        }

        return $next($request);
    }
}
