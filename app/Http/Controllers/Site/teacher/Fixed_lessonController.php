<?php

namespace App\Http\Controllers\Site\teacher;

use App\Http\Controllers\Controller;
use App\Models\Fixed_lesson;
use App\Models\Lesson;
use App\Models\Location;
use Illuminate\Http\Request;

class Fixed_lessonController extends Controller
{

    public function show($slug)
    {
        $fixed_lesson = Fixed_lesson::where('slug', $slug)->first();

        if ($fixed_lesson->user_id !== auth()->user()->id){
            abort(403);
        }

        $nextLessonDate = $fixed_lesson->scheduledLessons()->orderBy('date', 'ASC')->first()->start;

        return view('site.teacher.fixed_lessons.show', compact(['fixed_lesson', 'nextLessonDate']));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'location' => 'required|string|min:3|max:100',
            'date' => 'required|string|max:21',
        ]);

        $fixed_lesson = Fixed_lesson::where('slug', $slug)->first();

        if ($fixed_lesson->user_id !== auth()->user()->id) {
            return new \Exception(403);
        }

        $fixed_lesson->location_id = Location::getId($request->location);
        $fixed_lesson->start_date = date('Y-m-d', strtotime($request->date));
        $fixed_lesson->time = date('H:i:s', strtotime($request->date));
        $fixed_lesson->updateStudents($request->selected ?? [], $fixed_lesson->id);

        $fixed_lesson->save();

        Lesson::destroy(array_of_column($fixed_lesson->scheduledLessons, 'id'));

        //Create the first child lesson
        $request = $request->all();
        $request['fixed_lesson_id'] = $fixed_lesson->id;
        $lesson = Lesson::createLesson($request);


        //Create the other lessons
        auth()->user()->guarantee8weeksSchedule();

        return redirect()->route('fixedLessons.show', $slug)->with('success', 'Aula atualizada com sucesso');
    }


    public function destroy($id)
    {
        //
    }
}
