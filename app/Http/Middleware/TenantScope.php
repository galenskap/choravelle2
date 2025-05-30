<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TenantScope
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->hasRole('super_admin')) {
            // Vérifier que l'utilisateur accède uniquement aux données de son tenant
            $tenant_id = auth()->user()->tenant_id;
            
            // Vous pouvez ajouter ici une logique supplémentaire pour vérifier
            // l'accès aux ressources en fonction du tenant
        }

        return $next($request);
    }
} 