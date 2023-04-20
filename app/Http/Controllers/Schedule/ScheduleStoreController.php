<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
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
        unset($request['nama']);
        unset($request['draft']);
        unset($request['publish']);
        $petugas = ','.implode(",", request('nama')).',';
        $request['app'] = auth()->user()->app;
        $request['petugas'] = $petugas;
        $request['published'] = request('publish') ? true : false;
        if (!empty(request('nama')))
            $request['status'] = count(request('nama')) < request('jml_petugas') ? 'open' : 'close';
        
        Schedule::create($request);

        return redirect()->route('schedule.create')->with('status', 'schedule-created');
        return redirect()->back();
    }
}
