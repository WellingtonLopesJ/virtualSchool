<?php

namespace App\Http\Controllers\Site\teacher;

use App\Http\Controllers\Controller;
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

        if(empty(trim($query)) || $query === $results)
            $results = [];

        return response()->json($results);
    }
}
