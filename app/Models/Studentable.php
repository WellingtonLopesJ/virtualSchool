<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studentable extends Model
{
    protected $fillable = ['studentable_id', 'studentable_type', 'student_id'];

    public static function addStudents($studentable_id, $studentable_type, $students_ids)
    {
        $result = response('erro ao criar');

        if (is_array($students_ids)) {
            foreach ($students_ids as $id) {
                $result = Studentable::create(['studentable_id' => $studentable_id, 'studentable_type' => $studentable_type, 'student_id' => $id]);
            }
        }
        elseif($students_ids){
            $result = Studentable::create(['studentable_id' => $studentable_id, 'studentable_type' => $studentable_type, 'student_id' => $students_ids]);
        }

        return $result;
    }
}
