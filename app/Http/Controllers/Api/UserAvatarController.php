<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function response;

class UserAvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        $this->validate(\request(),[
            'avatar' => ['required','image']
        ]);

        auth()->user()->update([
            'avatar_path' => \request()->file('avatar')->storeAs('avatars','avatar.jpg','public')
        ]);

        return response([],204);
    }
}
