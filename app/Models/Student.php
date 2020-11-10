<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Student extends Model
{
    protected $visible = ['name', 'id', 'date_of_birth'];
    protected $fillable = ['name', 'date_of_birth'];


    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    public function historics()
    {
        return $this->hasMany(Historic::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->morphToMany(Location::class, 'locationable');
    }

    public function lessons()
    {
        return $this->morphedByMany(Lesson::class, 'studentable');
    }

    public function scheduledLessons()
    {
        return $this->lessons()->where('date', '>', date('Y-m-d H:i:s'))->where('canceled', 0);
    }

    public function computeCurrentBalance()
    {
       $lessons = $this->lessons()
            ->where('date', '<', date('Y-m-d H:i:s'))
            ->where('canceled', 0)
           ->doesntHave('historics')
           ->get();


      foreach ($lessons as $lesson){

            $lesson->subtractFromBalance();

        }

    }

    public function addLocation($location_id)
    {
        Locationable::addStudent($this->id, $location_id);
    }

    public function slug($student_name = null)
    {
        $name = explode(' ', $student_name ?? $this->name);
        $name = $name[0] ." ". $name[1];

        $slug = Str::slug($name, '-');

        if (Student::where('slug', $slug)->exists()){
            $slug = $slug . (Student::where('slug', $slug)->get()->count() + 1);
        }

        return $slug;
    }

    public function getCreditsAttribute()
    {
        return $this->balance()->firstOrCreate(['student_id' => $this->id],[ 'amount' => 0])->amount;
    }

    public function getFormatedBirthdayAttribute()
    {
        return date('d/m/Y', strtotime($this->date_of_birth));
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->slug();
    }
}
