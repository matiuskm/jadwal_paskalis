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
        // declare jadwal terbuka
        if (auth()->user()->role == 'admin')
            $jadwal_buka = Schedule::select('id', 'tgl_jadwal', 'jam_jadwal', 'lokasi')
                            ->where(DB::raw('timestamp(tgl_jadwal, jam_jadwal)'), '>=', date('Y-m-d H:i'))
                            ->where('status', 'open')
                            ->where('published', true)
                            ->select('id', 'tgl_jadwal', 'jam_jadwal', 'lokasi')->get();
        else if (auth()->user()->role == 'moderator')
            $jadwal_buka = Schedule::select('id', 'tgl_jadwal', 'jam_jadwal', 'lokasi')
                            ->where(DB::raw('timestamp(tgl_jadwal, jam_jadwal)'), '>=', date('Y-m-d H:i'))
                            ->where('status', 'open')
                            ->where('app', auth()->user()->app)
                            ->where('published', true)
                            ->select('id', 'tgl_jadwal', 'jam_jadwal', 'lokasi')->get();
        else $jadwal_buka = Schedule::select('id', 'tgl_jadwal', 'jam_jadwal', 'lokasi')
                            ->where(DB::raw('timestamp(tgl_jadwal, jam_jadwal)'), '>=', date('Y-m-d H:i'))
                            ->where('status', 'open')                    
                            ->where('app', auth()->user()->app)
                            ->where('petugas', 'not like', '%,'.auth()->user()->id.',%')
                            ->where('published', true)->get();

        // declare jadwal logged in user
        if (auth()->user()->role == 'admin')
            $jadwal = [];
        else if (auth()->user()->role == 'moderator')
            $jadwal = Schedule::where(DB::raw('timestamp(tgl_jadwal, jam_jadwal)'), '>=', date('Y-m-d H:i'))
                        ->where('app', auth()->user()->app)
                        ->where('published', true)
                        ->where('petugas', 'like', '%,'.auth()->user()->id.',%')
                        ->get();
        else $jadwal = Schedule::where(DB::raw('timestamp(tgl_jadwal, jam_jadwal)'), '>=', date('Y-m-d H:i'))
                        ->where('published', true)
                        ->where('app', auth()->user()->app)
                        ->where('petugas', 'like', '%,'.auth()->user()->id.',%')
                        ->get();
        if (!empty($jadwal))
            foreach($jadwal as $j) {
                $nama = User::select('name')->whereIn('id', explode(',', substr($j->petugas, 1, -1)))->get();
                if (!empty($nama))
                    $j->petugas = $nama;
                else
                    $j->petugas = null;
            }

        // declare semua jadwal untuk admin dan moderator
        $all_jadwal = [];
        if (auth()->user()->role == 'admin')
            $all_jadwal = Schedule::where(DB::raw('timestamp(tgl_jadwal, jam_jadwal)'), '>=', date('Y-m-d H:i'))->get();
        else if (auth()->user()->role == 'moderator')
            $all_jadwal = Schedule::where(DB::raw('timestamp(tgl_jadwal, jam_jadwal)'), '>=', date('Y-m-d H:i'))
                    ->where('app', auth()->user()->app)
                    ->get();
        if (!empty($all_jadwal))
            foreach($all_jadwal as $j) {
                $nama = User::select('name')->whereIn('id', explode(',', substr($j->petugas, 1, -1)))->get();
                if (!empty($nama))
                    $j->petugas = $nama;
                else
                    $j->petugas = null;
            }

        if (in_array(auth()->user()->role, ['admin', 'moderator']))
            return view('jadwal', ['jadwal' => $jadwal, 'jadwal_buka' => $jadwal_buka, 'semua_jadwal' => $all_jadwal]);
        else
            return view('jadwal', ['jadwal' => $jadwal, 'jadwal_buka' => $jadwal_buka]);
    }
}
