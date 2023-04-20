<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleEditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $schedule = Schedule::find($id);
        $schedule->petugas = explode(',',substr($schedule->petugas, 1, -1));
        if (auth()->user()->role == 'admin')
            $nama = User::where('status', true)->where('role', '!=', 'admin')->get();
        else $nama = User::where('status', true)->where('app', auth()->user()->app)->where('role', '!=', 'admin')->get();
        $params = ['schedule' => $schedule, 'nama' => $nama];
        // dd($params);
        return view('schedule.edit', $params);
    }
}
