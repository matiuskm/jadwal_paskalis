<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleAssignController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $schedule = Schedule::find($id);
        $persons = explode(',',substr($schedule->petugas, 1, -1));
	    if ($persons[0] == '') $persons = [];
	    if (in_array(auth()->user()->id, $persons)) return redirect('jadwal')->with('error', 'Anda sudah bertugas untuk jadwal ini.');

        $persons[] = auth()->user()->id;
	    $old_persons = count($persons);
	    if ($schedule->jml_petugas < $old_persons) return redirect('jadwal')->with('error', 'Jadwal ini sudah terisi penuh.');
        $persons = "," . implode(",", $persons) . ",";
        $schedule->update([
                        'petugas' => $persons,
                        'status' => $schedule->jml_petugas > $old_persons ? 'open' : 'close'
                    ]);

        Activity::create([
            'action' => "assign",
            'user_id' => auth()->user()->id,
            'schedule_id' => $id
        ]);
            
        return redirect('jadwal')->with('success', "Jadwal berhasil diambil, silakan cek jadwal Anda yang baru.");
    }
}
