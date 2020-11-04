<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Role_user;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //Formulário para atribuir role a user
    public function giveRole(Request $request)
    {
        $user = User::where('name',$request->user_name)->first();
        $roles = Role::all();

        return view('admin.users.giveRole', compact(['user', 'roles']));
    }

    //Faz permanencia do role_user
    public function storeRole(Request $request)
    {

        $roles = $request->roles;
        $user = User::where('name',$request->name_id)->where('tenant_id', $this->TManager->tenantId())->first();

        $user->addRole($roles);

        return redirect()->route('users.show', $user->name)->with('success', 'Role(s) atribuidos com sucesso');
    }

    //Remove role do user
    public function removeRole(Request $request)
    {

        $id = Role_user::all()->where('role_id', $request->role_id)->where('user_id', $request->user_id)->first()->id;

        Role_user::destroy($id);

        return redirect()->back()->with('success','Role removido do user com sucesso');
    }

    public function index()
    {
        $users = User::get();

        if ($this->TManager->tenantId() == 1){
            $users = User::all();
        }

        return view('admin.users.index', compact('users'));
    }


    public function create(Request $request)
    {
        $roles = Role::all();

        return view('admin.users.create', compact(['roles']));
    }


    public function store(Request $request)
    {
        $user = User::create([
            'tenant_id' => $this->TManager->tenantId(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //Se tiver especificado algum role atribui ao user
        if ($request->roles){
         $user->addRole($request->roles);
        }

        return redirect()->route('users.index')->with('success','Usuário criado com sucesso');
    }


    public function show($name)
    {
        $user = User::where('name', $name)->first();
        $roles = $user->roles;
        $tenant = $user->tenant();


        return view('admin.users.show', compact(['user', 'roles','tenant']));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($name)
    {

        //Recupera o user pelo name
        $user = User::where('name', $name)->first();

        //Se o user pertence ao tenant logado OU tenant logado é admin
        if ($user->tenant_id == $this->TManager->tenantId() || $this->TManager->tenantId() == 1){

            $id = $user->id;
            User::destroy($id);

            return redirect()->back()->with('success','Usuário deletado com sucesso');
        }

        return redirect()->back()->with('error','Não pode deletar esse usuário');

    }

}
