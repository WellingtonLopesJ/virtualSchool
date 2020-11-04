<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['user_id', 'fixed_lesson_id', 'location_id', 'date', 'canceled'];

    public static function createLesson($request)
    {
        $data = [];

        $data['user_id'] = auth()->user()->id;
        $data['location_id'] = Location::getId($request['location']);
        $data['date'] = $request['date'];

        $lesson = Lesson::create($data);

        if ($request['selected'])
        $lesson->addStudents($request['selected']);

    }

    public function addStudents($students_ids)
    {
        return Studentable::addStudents($this->id, 'app/models/lesson', $students_ids);
    }
}
