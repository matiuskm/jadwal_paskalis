<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetEditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $tweet = Tweet::find($id);
        $this->authorize('update', $tweet);
        return view('tweets.edit', ['tweet' => $tweet]);
    }
}
