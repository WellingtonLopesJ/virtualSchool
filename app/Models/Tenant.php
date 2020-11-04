<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['subdomain','name', 'uuid'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


}
