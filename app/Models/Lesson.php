<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['user_id', 'fixed_lesson_id', 'location_id', 'date', 'canceled', 'slug'];
    protected $visible = ['title', 'start', 'end', 'url', 'eventBackgroundColor'];



    public static function createLesson($request)
    {
        $data = [];

        if (isset($request['fixed_lesson_id'])){
            $data['fixed_lesson_id'] = $request['fixed_lesson_id'];
        }

        $data['user_id'] = auth()->user()->id;
        $data['location_id'] = $request['location_id'] ?? Location::getId($request['location']);
        $data['date'] = date('Y-m-d H:i:s' , strtotime($request['date']));
        $data['slug'] = Lesson::slug();


        $lesson = Lesson::create($data);


        if (isset($request['selected'])) {
            $lesson->addStudents($request['selected']);
        }

        return $lesson;
    }

    public static function slug()
    {
        $slug = bin2hex(random_bytes(5));

        if (Lesson::where('slug', $slug)->exists()){
            return Lesson::slug();
        }

        return $slug;
    }

    public function addStudents($students_ids)
    {
        return Studentable::addStudents($this->id, 'App\Models\Lesson', $students_ids);
    }

    public function updateStudents($students_ids, $lesson_id)
    {
        $currentRelations = Studentable::where([
            ['studentable_type', 'App\Models\Lesson'],
            ['studentable_id', $lesson_id]
        ])->get();

        Studentable::destroy(array_of_column($currentRelations, 'id'));
        $this->addStudents($students_ids);
    }

    public function students()
    {
        return $this->morphToMany(Student::class,'studentable');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getTitleAttribute()
    {
        return $this->students()->first()->name ?? $this->location->address ?? null;
    }

    public function getStartAttribute()
    {
        return date('Y-m-d',strtotime($this->date)) . 'T' . date('H:i:s', strtotime($this->date));
    }

    public function getEndAttribute()
    {
        $date = strtotime('+40 minutes',  strtotime($this->date));

        return date('Y-m-d', $date) . 'T' . date('H:i:s', $date);
    }

    public function getUrlAttribute()
    {
        return route('aulas.show', $this->slug);
    }

    public function getEventBackgroundColorAttribute()
    {
        $color = "#007bff";

        if ($this->canceled == true){
            $color = "#a9a9a9";
        }

        $now = date('Y-m-d H:i:s');
        $date = date('Y-m-d H:i:s', strtotime($this->date));
        if ($date < $now){
            $color = "#a9a9a9";
        }

        return $color;
    }

    public function getFormatedDateAttribute()
    {
        return date('d/m/Y H:i', strtotime($this->date));
    }


}
