<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserEditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $user = User::find($id);
        if (auth()->user()->role != 'admin')
            if ($user->app != auth()->user()->app)
                return redirect()->route('user.index')->with('error', 'Anda tidak memiliki hak untuk mengubah user ini.');
        
        return view('user.edit', ['user' => $user]);
    }
}
