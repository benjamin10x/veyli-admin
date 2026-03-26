<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EnsureRoleAccess
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Session::get('api_user');
        if (!$user || (count($roles) && !in_array($user['role'] ?? '', $roles, true))) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a este módulo.');
        }

        return $next($request);
    }
}
