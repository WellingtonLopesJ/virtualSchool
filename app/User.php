<?php

namespace App;

use App\Models\Lesson;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Role;
use App\Models\Role_user;
use App\Models\Tenant;
use App\Tenant\Scopes\TenantScope;
use App\Tenant\TenantManager;
use App\Tenant\Traits\TenantTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'tenant_id'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function scheduledLessons()
    {
        return $this->lessons()->where('date', '>', date('Y-m-d H:i:s'))->where('canceled', 0);
    }

    //Atribui role ao user
    public function addRole($roles)
    {
        app(Role_user::class)->roleToUser($roles, $this->id);
    }

    //Retorna tenant do usuário
    public function tenant()
    {
        return Tenant::find($this->tenant_id);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            Role::class,
            'user_id', // Foreign key on users table...
            'role_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'id' // Local key on users table...
        );
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission($permissionName)
    {
        $roles = Permission::all()->where('name', $permissionName)->first()->roles;

        $userRoles = Auth::user()->roles;

        return $this->hasAnyRole($roles) && app(TenantManager::class)->matchUserSubdomain();
    }

    public function hasAnyRole($roles)
    {
        if (is_object($roles) || is_array($roles)){

            foreach ($roles as $role){
                if(  !$this->emptyObj($this->roles->where('name', $role->name))){
                    return true;
                }
            }
        }

        return false;
    }


    public function emptyObj( $obj ) {
        foreach ( $obj AS $prop ) {
            return FALSE;
        }

        return TRUE;
    }

    public function isAdmin()
    {
        return $this->id == 1;
    }
}
