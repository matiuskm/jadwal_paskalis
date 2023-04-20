<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleCreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        if (auth()->user()->role == 'admin')
            $nama = User::where('status', true)->where('role', '!=', 'admin')->get();
        else $nama = User::where('status', true)->where('app', auth()->user()->app)->where('role', '!=', 'admin')->get();
        
        return view('schedule.create', ['nama'=>$nama]); 
    }
}
