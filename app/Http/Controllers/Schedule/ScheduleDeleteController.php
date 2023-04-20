<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        Schedule::findOrFail($id)->delete();

        return redirect()->back();
    }
}
