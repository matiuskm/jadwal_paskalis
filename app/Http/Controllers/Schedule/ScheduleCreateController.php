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
        $nama = User::where('status', true)->where('app', auth()->user()->app)->where('role', '!=', 'admin')->get();
        
        return view('schedule.create', ['nama'=>$nama]); 
    }
}
