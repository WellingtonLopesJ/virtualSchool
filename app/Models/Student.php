<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $visible = ['name', 'id', 'date_of_birth'];

    public function getFormatedBirthdayAttribute()
    {
        return date('d/m/Y', strtotime($this->date_of_birth));
    }
}
