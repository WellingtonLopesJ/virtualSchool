<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locationable extends Model
{
    protected $fillable = ['locationable_type', 'locationable_id', 'location_id'];

    public static function addStudent($student_id, $location_id)
    {
        Locationable::create(['locationable_type' => 'App\Models\Student', 'locationable_id' => $student_id, 'location_id' => $location_id]);
    }
}
