<?php


namespace App\Tenant\Scopes;


use App\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class RoleScope implements Scope {

    public function apply(Builder $builder, Model $model)
    {

        $builder->where('id','>', 2);
    }
}
