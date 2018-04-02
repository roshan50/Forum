<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        $search = \request('q');
        return Thread::search($search)->paginate(5);

        if(\request()->expectsJson()){
            return $threads;
        }

        $trending = $trending->get();
        return view('threads.index',compact('threads','trending'));
    }
}
