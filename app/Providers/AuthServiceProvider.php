<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if(Schema::hasTable('permissions')){

            $permissions = Permission::all();

            Gate::before(function ($user) {
                if ($user->isAdmin()) {
                    return true;
                }
            });

            foreach ($permissions as $permission){

                Gate::define($permission->name, function ($user) use($permission) {

                    return $user->hasPermission($permission->name);

                });
            }

        }

    }
}
