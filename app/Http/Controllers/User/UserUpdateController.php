<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $user = User::find($id);
        $request = request()->validate([
            'name' => ['string', 'max:255'],
            'dob' => ['date'],
            'email' => ['email', 'nullable', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'role' => ['string']
        ]);
        $user->update($request);

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate.');
    }
}
