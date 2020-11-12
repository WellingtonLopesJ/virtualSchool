<?php

namespace App\Http\Controllers\Site\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class ReportController extends Controller
{
    public function index()
    {
        $students = auth()->user()->students()->whereHas('balance', function (Builder $query){
            $query->where('amount', '<=', 0);
        })->get();

        return view('site.teacher.reports.index', compact(['students']));
    }
}
