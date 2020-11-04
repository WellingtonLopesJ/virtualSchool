<?php

namespace App\Http\Middleware\Tenant;

use App\Tenant\TenantManager;
use Closure;
use Illuminate\Support\Facades\Auth;

class TenantMiddleware
{

    public function handle($request, Closure $next)
    {
        $tenantManager = app( TenantManager::class);

        //Check if subdomain is valid
        if ( !$tenantManager->validSubdomain())
            abort(404);

        $this->setSession($tenantManager->tenantSubdomain());
        return $next($request);
    }

    public function setSession($tenant)
    {
        session()->put('tenant', $tenant->only('name'));
    }


}
