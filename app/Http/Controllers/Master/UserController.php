<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserFormRequest;
use App\Models\Role;
use App\Models\Role_user;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //Mostrar detalhes do role
    public function roleDetail($id)
    {
       $role = Role::find($id);
       $permissions = $role->permissions;
       return view('panel.roles.permissions', compact(['role','permissions']));
    }


    //Formulário para atribuir role a user
    public function giveRole(Request $request)
    {
        $user = User::where('name',$request->user_name)->where('tenant_id',$this->TManager->tenantId())->first();
        $roles = Role::all()->where('id', '>', 2);

        return view('panel.users.giveRole', compact(['user', 'roles']));
    }

    //Faz permanencia do role_user
    public function storeRole(Request $request)
    {
        if (!$request->roles){
            return redirect()->route('users.index')->with('error','Não selecionou nenhum role');
        }

        //Verifica se o role é válido
        foreach ($request->roles as $role){
            if ($role < 3 || $role > 7 || !is_int($role)){
                return redirect()->route('users.index')->with('error', 'invalid');
            }
        }


        $roles = $request->roles;
        $user = User::where('name',$request->user_name)->where('tenant_id', $this->TManager->tenantId())->first();

        $user->addRole($roles);

        return redirect()->route('users.show', $user->name)->with('success', 'Role(s) atribuidos com sucesso');
    }

    //Remove role do user
    public function removeRole(Request $request)
    {

        $id = Role_user::all()->where('role_id', $request->role_id)->where('user_name', $request->user_name)->first()->id;

        Role_user::destroy($id);

        return redirect()->back()->with('success','Role removido do user com sucesso');
    }

    public function index()
    {
        $users = User::get()->where('tenant_id', $this->TManager->tenantId());

        //Retorna todos os users se for admin
        if (Gate::allows('admin_area')){
            $users = User::all();
        }

        return view('panel.users.index', compact('users'));
    }


    public function create(Request $request)
    {
        $roles = Role::all();

        return view('panel.users.create', compact(['roles']));
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


        return view('panel.users.show', compact(['user', 'roles','tenant']));
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
        $user = User::all()->where('name', $name)->first();

        //Se o user pertence ao tenant logado OU tenant logado é admin
        if ($user->tenant_id == $this->TManager->tenantId() || $this->TManager->tenantId() == 1){

            $id = $user->id;
            User::destroy($id);

            return redirect()->route('users.index')->with('success','Usuário deletado com sucesso');
        }

        return redirect()->back()->with('error','Não pode deletar esse usuário');

    }
}
