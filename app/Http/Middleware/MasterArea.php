<?php

namespace App\Http\Middleware;

use App\Tenant\TenantManager;
use Closure;
use Illuminate\Support\Facades\Gate;

class MasterArea
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isMaster = app(TenantManager::class)->isMasterTenant();


        if (Gate::denies('master_area')){
            abort(403);
        }

        return $next($request);
    }
}
