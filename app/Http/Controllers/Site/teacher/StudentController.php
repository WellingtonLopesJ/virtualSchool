<?php

namespace App\Http\Controllers\Site\teacher;

use App\Http\Controllers\Controller;
use App\Models\Fixed_lesson;
use App\Models\Lesson;
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
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
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
