<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{
    protected $table = 'role_user';

    protected $fillable = ['role_id', 'user_id'];

    public $timestamps = false;

    //Atribui role a um user

    public function roleToUser($roles, $userId)
    {
        if (is_array($roles)) {
            foreach ($roles as $roleId) {
                Role_user::create(['role_id' => $roleId, 'user_id' => $userId]);
            }
        }else{
            Role_user::create(['user_id' => $userId, 'role_id' => $roles]);
        }
    }
}
