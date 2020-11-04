<?php


namespace App\Tenant\Observers;


use App\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Model;

class TenantObserver
{
    public function creating(Model $model){
        $tenantId = app(TenantManager::class)->tenantId();
        $model->setAttribute('tenant_id', $tenantId);
    }

}
