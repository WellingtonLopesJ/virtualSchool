<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixed_lesson extends Model
{
    protected $fillable = ['user_id', 'location_id', 'start_date', 'time', 'end_date', 'slug'];

    public static function createFixed_lesson($request)
    {
        //Set the array of values for creating the fixed_lesson
        $data = [];
        $data['user_id'] = auth()->user()->id;
        $data['location_id'] = Location::getId($request['location']);
        $data['start_date'] = date('Y-m-d',strtotime($request['date']));
        $data['time'] = date('H:i', strtotime($request['date']));
        $data['slug'] = Fixed_lesson::slug();

        if ($request['end_date']){
            $data['end_date'] = date('Y-m-d', strtotime($request['end_date']));
        }

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


    public static function slug()
    {
        $slug = bin2hex(random_bytes(5));

        if (Lesson::where('slug', $slug)->exists() || Fixed_lesson::where('slug', $slug)->exists()){
            return Fixed_lesson::slug();
        }

        return $slug;
    }

    public function addStudents($students_ids)
    {
        return Studentable::addStudents($this->id, 'App\Models\Fixed_lesson', $students_ids);
    }

    public function updateStudents($students_ids, $lesson_id)
    {
        $currentRelations = Studentable::where([
            ['studentable_type', 'App\Models\Fixed_lesson'],
            ['studentable_id', $lesson_id]
        ])->get();

        Studentable::destroy(array_of_column($currentRelations, 'id'));
        $this->addStudents($students_ids);
    }

    public function students()
    {
        return $this->morphToMany(Student::class,'studentable');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function scheduledLessons()
    {
        return $this->lessons()->where('date', '>', date('Y-m-d H:i:s'))->where('canceled', 0);
    }

}
