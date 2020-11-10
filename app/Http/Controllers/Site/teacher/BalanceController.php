<?php

namespace App\Http\Controllers\Site\teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\MoneyValidationFormRequest;
use App\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function deposit($slug)
    {
        $student = auth()->user()->students()->where('slug', $slug)->first();

        return view('site.teacher.balance.deposit', compact('student'));
    }

    public function depositStore(MoneyValidationFormRequest $request)
    {
        $student = auth()->user()->students()->where('slug', $request->student_slug)->first();
        $balance = $student->balance()->firstOrCreate(['student_id' => $student->id],['amount' => 0]);
        $response = $balance->deposit($request->value, $student);

        if($response['success']){
            return redirect()->route('alunos.show', $student->slug)->with('success',  $response['message']);
        }else{
            return redirect()->back()->with('error',  $response['message']);
        }
    }
}
