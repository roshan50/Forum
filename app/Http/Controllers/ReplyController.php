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
        $this->middleware('auth'); 
    }

    public function store($channelId,Thread $thread){
        $this->validate(request(),[
            'body'  => 'required'
        ]);
        $thread->addReply([
            'body'      => request('body'),
            'user_id'   => auth()->id()
        ]);

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
