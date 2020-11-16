<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lesson extends Model
{
    protected $fillable = ['user_id', 'fixed_lesson_id', 'location_id', 'date', 'canceled', 'slug'];
    protected $visible = ['title', 'start', 'end', 'url', 'color'];

    public function subtractFromBalance()
    {
        $students = $this->students;

        foreach ($students as $student){

           $student->balance()->firstOrCreate([], ['amount' => 0])->withdraw(1, $this->id);

        }

    }

    public function refundCancelled()
    {
        $historics = $this->historics()->where('type','O')->get();

        if ($historics->count() > 0){

            foreach ($historics as $historic){
                $student = $historic->student;

                $student->balance->deposit($historic->amount, $student, $this->id);
            }

        }
    }

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

        if (Lesson::where('slug', $slug)->exists() || Fixed_lesson::where('slug', $slug)->exists()){
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

    public function fixed_lesson()
    {
        return $this->belongsTo(Fixed_lesson::class);
    }

    public function historics()
    {
        return $this->hasMany(Historic::class);
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

    public function getColorAttribute()
    {
        $color = "#3788d8";

        $now = date('Y-m-d H:i:s');
        $date = date('Y-m-d H:i:s', strtotime($this->date));

        if ($this->canceled == true || $date < $now){
            $color = "gray";
        }


        return $color;
    }

    public function getFormatedDateAttribute()
    {
        return date('d/m/Y H:i', strtotime($this->date));
    }


}
