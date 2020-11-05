<?php

namespace App\Http\Controllers\Site\teacher;

use App\Http\Controllers\Controller;
use App\Models\Fixed_lesson;
use App\Models\Lesson;
use App\Models\Location;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    public function fetchLessons()
    {
        $lessons = auth()->user()->lessons()->orderBy('date', 'DESC')->limit(30)->get();

        return $lessons->append(['title', 'start', 'end', 'url'])->toArray();
    }

    public function index()
    {
        $lessons = auth()->user()->scheduledLessons;

        return view('site.teacher.lessons.index', compact('lessons'));
    }


    public function create()
    {
        return view('site.teacher.lessons.create');
    }


    public function store(Request $request)
    {

        if ($request->repeat === 'single'){
            Lesson::createLesson($request->only(['location', 'selected', 'date']));
        }

        if ($request->repeat === "weekly"){
            Fixed_lesson::createFixed_lesson($request->only(['location', 'selected', 'date']));
        }
    }


    public function show($slug)
    {
        $lesson = Lesson::where('slug', $slug)->first();

        if ($lesson->user_id !== auth()->user()->id){
            return redirect()->back()->with('error', 'Não autorizado');
        }

        $students = $lesson->students;

        return view('site.teacher.lessons.show', compact(['lesson', 'students']));
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
