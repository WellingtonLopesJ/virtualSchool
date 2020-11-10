<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $fillable = ['user_id', 'type', 'amount', 'total_before', 'total_after', 'user_id_transaction','date','lesson_id','created_at','updated_at'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
