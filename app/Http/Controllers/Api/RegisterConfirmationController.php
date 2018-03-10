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
       $user = User::where('confirmation_token',\request('token'))
            ->first();
       if(! $user){
           return redirect('/threads')->with('flash','unknown token!');
       }

       $user->confirm();

        return redirect('/threads')->with('flash','Your acount is now confirmed!');
    }
}
