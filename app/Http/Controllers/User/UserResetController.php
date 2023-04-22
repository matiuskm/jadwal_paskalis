<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserResetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        User::find($id)->update(
            ['password' => Hash::make("paskalis123")]
        );
        return redirect()->route('user.index')->with('success', 'Password berhasil direset.');
    }
}
