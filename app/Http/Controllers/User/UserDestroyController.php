<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        User::find($id)->update([
            'status' => false
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil dinonaktifkan.');
    }
}
