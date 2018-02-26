<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use function back;
use Illuminate\Http\Request;
use function response;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>'index']);
    }

    public function index($channelId,Thread $thread)
    {
        return $thread->replies()->paginate(2);
    }

    public function store($channelId,Thread $thread)
    {
        $this->validate(request(),[
            'body'  => 'required'
        ]);
        $reply = $thread->addReply([
            'body'      => request('body'),
            'user_id'   => auth()->id()
        ]);

        if(\request()->expectsJson()){
            return $reply->load('owner');
        }

        return back()->with('flash','your reply has been left');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update',$reply);
        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update',$reply);
        $reply->delete();
        if(\request()->expectsJson()){
            return response(['status' => 'reply deleted!']);
        }
        return back();
    }
}
