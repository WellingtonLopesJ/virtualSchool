<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Permission_role;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function addPermission(Request $request, $id)
    {
        $role = Role::all()->where('id', $id)->first();
        $permissions = Permission::all();

        return view('admin.roles.addPermission', compact(['role', 'permissions']));
    }

    public function storePermission(Request $request, $id)
    {
        Permission_role::create(['permission_id' => $request->permissionId, 'role_id' => $id]);

        return redirect()->route('roles.permissions', $id)->with('success','Permission adicionada ao role');
    }

    public function removePermission(Request $request)
    {
       $id = Permission_role::all()->where('permission_id', $request->permissionId)->where('role_id',$request->roleId)->first()->id;

        Permission_role::destroy($id);

        return redirect()->back()->with('success','Permission removida do role');
    }

    public function permissions($id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions;

        return view('admin.roles.permissions',compact(['role','permissions']));
    }

    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }


    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {

       $role = Role::create($request->only(['name','label']));

       return redirect()->route('roles.index')->with('success', 'Role criado com sucesso');
    }


    public function show($id)
    {
        //
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
        Role::destroy($id);
        return redirect()->back()->with('success', 'Role deletado com sucesso');
    }
}
