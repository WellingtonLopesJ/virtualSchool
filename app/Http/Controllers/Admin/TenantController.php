<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class TenantController extends Controller
{

    public function index()
    {
        $tenants = Tenant::all();
        return view('admin.tenants.index', compact('tenants'));
    }


    public function create()
    {
        return view('admin.tenants.create');
    }


    public function store(Request $request)
    {
        //Cria tenant
        $tenant = Tenant::create(['subdomain' => $request->subdomain, 'uuid' => Str::uuid(), 'name' => $request->name]);

        //Criar master user para o novo  tenant
        $userMaster = $tenant->users()->create([
            'name' => $request->subdomain . "Master",
            'email' => "{$request->subdomain}@master.com"
            ,'password' => bcrypt($request->password)
        ]);

        //Atribui role de master ao novo user
        $userMaster->addRole(2);

        return redirect()->route('tenants.index')->with('success', 'Tenant criado com sucesso');
    }


    public function show($id)
    {
        $tenant = Tenant::find($id);
        $users = $tenant->users;

        return view('admin.tenants.show', compact(['tenant','users']));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        Tenant::destroy($id);
        return redirect()->back()->with('success', 'Tenant deletado com sucesso');
    }
}
