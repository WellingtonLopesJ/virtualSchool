<?php


namespace App\Tenant;


use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class TenantManager
{

    //Checks if current user's subdomain corresponds to url subdomain
    public function matchUSerSubdomain()
    {
        return $this->tenant()->subdomain == $this->subdomain();
    }

    //Return tenant of the authenticated user
    public function tenant()
    {
        $tenant = Tenant::all()->where('id', auth()->user()->tenant_id)->first();

        return $tenant;
    }

    //Return tenant of the current url subdomain
    public function tenantSubdomain()
    {
        $tenant = app(Tenant::class)->where('subdomain', $this->subdomain())->first();

        return $tenant;
    }

    //Return current subdomain
    public function subdomain()
    {
        $raw = str_replace('http://', '', request()->url());
        $url = explode('.', $raw);

        return $url[0];
    }

    public function validSubdomain()
    {
        return Tenant::all()->where('subdomain', $this->subdomain())->count() >= 1;
    }

    public function tenantId()
    {
        return $this->tenant()->id;
    }

    public function isMain()
    {
        return $this->subdomain() == config('tenant.subdomain_main');
    }

    //Retorna se o usuário logado é Master de um tenant
    public function isMasterTenant()
    {
        $masters = config('masters.ids');

        return in_array(\auth()->user()->id, $masters);
    }
}
