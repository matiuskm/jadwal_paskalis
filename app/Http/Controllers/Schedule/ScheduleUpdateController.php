<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $request = request()->validate([
            'tgl_jadwal' => ['required', 'date'],
            'jam_jadwal' => ['required'],
            'nama_tugas' => ['required', 'string'],
            'lokasi' => ['required', 'string'],
            'warna' => ['required', 'string'],
            'jml_petugas' => ['required', 'numeric'],
            'draft' => ['nullable'],
            'publish' => ['nullable'],
            'nama' => ['nullable']
        ]);

        $schedule = Schedule::find($id);
        unset($request['nama']);
        unset($request['draft']);
        unset($request['publish']);
        $petugas = explode(",", request('nama'));
        $request['app'] = auth()->user()->app ?: request('app');
        $request['petugas'] = ','.request('nama').',';
        $request['published'] = request('publish') ? true : false;
        if (!empty(request('nama')))
            $request['status'] = count($petugas) < request('jml_petugas') ? 'open' : 'close';

        $schedule->update($request);
        return redirect()->route('jadwal')->with('status', 'schedule-created');
    }
}
