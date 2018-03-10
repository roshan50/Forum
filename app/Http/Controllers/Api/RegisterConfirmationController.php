<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use function redirect;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        User::where('confirmation_token',\request('token'))
            ->firstOrFail()
            ->confirm();

        return redirect('/threads')->with('flash','Your acount is now confirmed!');
    }
}
