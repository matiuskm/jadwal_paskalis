<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        if (auth()->user()->role == 'admin')
            $users = User::all();
        else $users = User::where('app', auth()->user()->app)->get();

        return view('user.index', ['users' => $users]);
    }
}
