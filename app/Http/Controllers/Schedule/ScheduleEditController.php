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
            $nama = User::where('status', true)->where('role', '!=', 'admin')->pluck('name', 'id');
        else $nama = User::where('status', true)->where('app', auth()->user()->app)->where('role', '!=', 'admin')->pluck('name', 'id');

        // dd($nama);
        $params = ['schedule' => $schedule, 'nama' => $nama];
        return view('schedule.edit', $params);
    }
}
