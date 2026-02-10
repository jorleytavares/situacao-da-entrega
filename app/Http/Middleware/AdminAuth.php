<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin_autenticado')) {
            return redirect()->route('admin.login')->with('erro', 'Faça login para acessar.');
        }

        return $next($request);
    }
}
