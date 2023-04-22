<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleReleaseController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $schedule = Schedule::find($id);
        $persons = explode(',',substr($schedule->petugas, 1, -1));
        $updated = array_diff($persons, [auth()->user()->id]);
        $persons = "," . implode(",", $updated) . ",";
        $schedule->update([
                    'petugas' => $persons,
                    'status' => $schedule->jml_petugas > count($updated) ? 'open' : 'close'
                ]);
        
        Activity::create([
            'action' => "release",
            'user_id' => auth()->user()->id,
            'schedule_id' => $id
        ]);
        
        return redirect('jadwal')->with('success', "Tugas sudah dilepaskan.");
    }
}
