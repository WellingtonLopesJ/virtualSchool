<?php

namespace App\Http\Controllers\Site\teacher;

use App\Http\Controllers\Controller;
use App\Models\Fixed_lesson;
use App\Models\Lesson;
use App\Models\Location;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{

    public function search(Request $request)
    {
        $query = $request->query('query');
        $selectedIds = $request->selectedIds ? $request->selectedIds : [];


        $results = Student::where('name', 'like', '%' . $query . '%')
            ->limit(5)
            ->whereNotIn('id', $selectedIds)
            ->get();


        if(empty(trim($query)))
            $results = [];

        return $results;
    }

    public function searchCurrentStudents($slug)
    {
        $lesson = Lesson::where('slug', $slug)->first() ?? Fixed_lesson::where('slug', $slug)->first();

        $students = $lesson->students()->get()->toArray();

        return $students;
    }

    public function index()
    {
        $students = auth()->user()->students()->paginate(20);

        return view('site.teacher.students.index', compact('students'));
    }


    public function create()
    {
        return view('site.teacher.students.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'location' => 'string|min:5|max:100',
            'birthday' => 'required|string|min:10|max:10'
        ]);

        $data = [];
        $data['name'] = $request->name;
        $data['date_of_birth'] = $request->birthday;

        $student = new Student($data);
        $student->user_id = auth()->user()->id;
        $student->save();

        //Add location to the student
        if ($request->location){
            $location_id = Location::getId($request->location);
            $student->addLocation($location_id);
        }

        return redirect()->route('aulas.index')->with('success', 'Aluno registrado com sucesso');
    }


    public function show($slug)
    {
        $student = auth()->user()->students()->where('slug', $slug)->first();
        $lessons = $student->scheduledLessons;

        return view('site.teacher.students.show', compact(['student', 'lessons']));
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
