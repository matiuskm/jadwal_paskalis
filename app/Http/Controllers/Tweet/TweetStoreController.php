<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        Tweet::create([
            'user_id' => Auth::id(),
            'content' => request('content'),
            'app' => Auth::user()->app,
        ]);

        return redirect()->back();
    }
}
