<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class SchedulePublishController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        Schedule::find($id)->update([
                'published' => true,
            ]);

        return redirect('jadwal')->with('success', 'Jadwal sudah dipublish.');
    }
}
