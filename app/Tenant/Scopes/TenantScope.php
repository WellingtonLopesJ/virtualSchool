<?php


namespace App\Tenant\Scopes;

use App\Tenant\TenantManager;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope {

    public function apply(Builder $builder, Model $model)
    {
        $tenantId = app(TenantManager::class)->tenantId();

        $builder->where('tenant_id', $tenantId);
    }
}
