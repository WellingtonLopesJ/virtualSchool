<?php

namespace App\Http\Controllers\Site\teacher;

use App\Http\Controllers\Controller;
use App\Models\Fixed_lesson;
use App\Models\Lesson;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query');


        $results = Location::where('address', 'like', '%' . $query . '%')
            ->limit(5)
            ->get();

        //Check if query is empty
        if(empty(trim($query)))
            $results = [];

        return response()->json($results);
    }

    public function searchCurrentLocation($slug)
    {
        $lesson = Lesson::where('slug', $slug)->first() ?? Fixed_lesson::where('slug', $slug)->first();

        return $lesson->location->address;

    }
}
