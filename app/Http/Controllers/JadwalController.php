<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $jadwal = Schedule::where(DB::raw('timestamp(tgl_jadwal, jam_jadwal)'), '>=', date('Y-m-d H:i'))->where('app', auth()->user()->app)->get();
        foreach($jadwal as $j) {
            $nama = User::select('name')->whereIn('id', explode(',', substr($j->petugas, 1, -1)))->get();
            if (!empty($nama))
                $j->petugas = $nama;
            else
                $j->petugas = null;
        }
        return view('jadwal', ['jadwal' => $jadwal]);
    }
}
