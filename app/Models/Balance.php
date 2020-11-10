<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Balance extends Model
{
    public $timestamps = false;

    protected $fillable = ['student_id', 'amount'];

    public function deposit($value, Student $student, $lesson_id = null) : array
    {
        DB::beginTransaction();

        Log::info('1:' . $lesson_id);

        $totalBefore = $this->amount;

        $this->amount += $value;
        $deposit = $this->save();

        $historic = $student->historics()->create([
            'student_id' => $student->id,
            'type' => 'I',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Ymd'),
            'lesson_id' => $lesson_id
        ]);

        if ($deposit && $historic){
            DB::commit();

            return ['success' => true, 'message' => 'Recarga feita com sucesso'];
        }else{
            DB::rollBack();

            return ['success' => false, 'message' => 'erro ao fazer recarga'];
        }
    }

    public function withdraw($value, $lesson_id)
    {
        DB::beginTransaction();

        $student = $this->student;
        $totalBefore = $this->amount;

        $this->amount -= $value;
        $withdrawal = $this->save();

        $historic = $student->historics()->create([
            'student_id' => $student->id,
            'type' => 'O',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Ymd'),
            'lesson_id' => $lesson_id
        ]);

        if ($withdrawal && $historic){
            DB::commit();

        }else{
            DB::rollBack();
        }
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
