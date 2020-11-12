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

        return $lessons->append(['title', 'start', 'end', 'url', 'color'])->toArray();
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

        $request->validate([
            'location' => 'string|required|min:5',
            'date' => 'required|date',
            'end_date' => 'date'
        ]);

        if ($request->repeat === 'single'){
            Lesson::createLesson($request->only(['location', 'selected', 'date']));
        }

        if ($request->repeat === "weekly"){
            Fixed_lesson::createFixed_lesson($request->only(['location', 'selected', 'date', 'end_date']));
        }

        return redirect()->route('aulas.index')->with('success','Aula criada com sucesso');
    }


    public function show($slug)
    {
        $lesson = Lesson::where('slug', $slug)->first();

        if ($lesson->user_id !== auth()->user()->id){
            abort(403);
        }

        $warnings = [];
        foreach ($lesson->students as $student){

            if ($student->credits < 2){
                $warnings[] = $student->name . ": tem " . $student->credits . " créditos";
            }

        }

        return view('site.teacher.lessons.show', compact(['lesson', 'warnings']));
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'location' => 'required|string|min:3|max:100',
            'date' => 'required|string|max:21',
        ]);

        $lesson = Lesson::where('slug', $slug)->first();

        if ($lesson->user_id !== auth()->user()->id) {
            return new \Exception(403);
        }

        $lesson->location_id = Location::getId($request->location);
        $lesson->date = date('Y-m-d H:i:s', strtotime($request->date));

        $lesson->updateStudents($request->selected ?? [], $lesson->id);

        if ($lesson->save())
        return redirect()->route('aulas.show', $slug)->with('success', 'Aula atualizada com sucesso');
    }

    public function cancel($slug)
    {
        $lesson = Lesson::where('slug', $slug)->first();

        if ($lesson->user_id !== auth()->user()->id){
            return redirect()->back()->with('error', 'Não autorizado');
        }

        if ($lesson->canceled){
            return redirect()->back()->with('error', 'Aula já estava cancelada');
        }

        $lesson->canceled = 1;
        $lesson->save();

        $lesson->refundCancelled();

        return redirect()->route('aulas.show', $slug)->with('success', 'Aula cancelada com sucesso');

    }

    public function unCancel($slug)
    {
        $lesson = Lesson::where('slug', $slug)->first();

        if ($lesson->user_id !== auth()->user()->id){
            return redirect()->back()->with('error', 'Não autorizado');
        }

        if (!$lesson->canceled){
            return redirect()->back()->with('error', 'Aula não estava cancelada');
        }

        $now = date('Y-m-d H:i:s');
        $date = date('Y-m-d H:i:s', strtotime($lesson->date));
        if ($date < $now){
            return redirect()->back()->with('error', 'Impossivel reestabelecer esta aula, data expirada');
        }

        $lesson->canceled = 0;
        $lesson->save();

        return redirect()->route('aulas.show', $slug)->with('success', 'Aula reestabelecida com sucesso');

    }

    public function destroy($id)
    {
        return "aa";
    }
}
