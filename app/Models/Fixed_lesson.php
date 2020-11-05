<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixed_lesson extends Model
{
    protected $fillable = ['user_id', 'location_id', 'start_date', 'time', 'end_date'];

    public static function createFixed_lesson($request)
    {
        //Set the array of values for creating the fixed_lesson
        $data = [];
        $data['user_id'] = auth()->user()->id;
        $data['location_id'] = Location::getId($request['location']);
        $data['start_date'] = date('Y-m-d',strtotime($request['date']));
        $data['time'] = date('H:i', strtotime($request['date']));

        $fixed_lesson = Fixed_lesson::create($data);

        //Add students to fixed_lesson
        if ($request['selected'])
            $fixed_lesson->addStudents($request['selected']);

        //Create the first child lesson
        $request['fixed_lesson_id'] = $fixed_lesson->id;
        $lesson = Lesson::createLesson($request);


        //Create the other lessons
        auth()->user()->guarantee8weeksSchedule();
    }

    public function addStudents($students_ids)
    {
        return Studentable::addStudents($this->id, 'App\Models\Fixed_lesson', $students_ids);
    }

    public function students()
    {
        return $this->morphToMany(Student::class,'studentable');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function scheduledLessons()
    {
        return $this->lessons()->where('date', '>', date('Y-m-d H:i:s'))->where('canceled', 0);
    }

}
