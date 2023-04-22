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
        $exists_schedule = Schedule::where('app', auth()->user()->app ?: request('app'))
                ->where('tgl_jadwal', request('tgl_jadwal'))
                ->where('jam_jadwal', request('jam_jadwal'))
                ->where('lokasi', request('lokasi'))->exists();
        if ($exists_schedule) return redirect()->route('schedule.create')->with('error', 'Jadwal sudah pernah dibuat.');

        unset($request['nama']);
        unset($request['draft']);
        unset($request['publish']);
        $petugas = explode(",", request('nama'));
        $request['app'] = auth()->user()->app ?: request('app');
        $request['petugas'] = ','.request('nama').',';
        $request['published'] = request('publish') ? true : false;
        if (!empty(request('nama')))
            $request['status'] = count($petugas) < request('jml_petugas') ? 'open' : 'close';
        
        Schedule::create($request);

        return redirect()->route('schedule.create')->with('success', 'Jadwal berhasil dibuat.');
        return redirect()->back();
    }
}
