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
            $users = User::paginate(10);
        else $users = User::where('app', auth()->user()->app)->paginate(10);

        return view('user.index', ['users' => $users]);
    }
}
