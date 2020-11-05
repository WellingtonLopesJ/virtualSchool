<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function getFormatedBirthdayAttribute()
    {
        return date('d/m/Y', strtotime($this->date_of_birth));
    }
}
