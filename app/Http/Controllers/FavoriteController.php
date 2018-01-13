<?php

namespace App\Http\Controllers;

use App\Favorite;
use function auth;
use function back;
use function get_class;
use Illuminate\Http\Request;
use App\Reply;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        $reply->favorite();
        return back();
//        $reply->favorites()->create(['user_id' => auth()->id()]);
//        Favorite::create([
//            'user_id'       => auth()->id(),
//            'favorited_id'  => $reply->id,
//            'favorited_type'=> get_class($reply)
//        ]);
    }
}
