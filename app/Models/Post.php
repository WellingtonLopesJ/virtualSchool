<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use TenantTrait;

    protected $fillable = ['tenant_id','user_id','title','body','image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
