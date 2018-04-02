<?php

namespace App\Http\Controllers;

use App\Http\Forms\CreatePostForm;
use App\Reply;
use App\Thread;
use App\User;
use function back;
use Illuminate\Http\Request;
use Mockery\Exception;
use function preg_match_all;
use function response;
use App\Notifications\YouWhereMentioned;

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
//        $this->authorize('create',new Reply);
//        if(Gate::denies('create',new Reply)){
//            return response(
//                'you are posting too frequently. please take a break :)',429
//            );
//        }

        if($thread->locked){
            return response('thread is locked',422);
        }

        try{
            $this->validate(request(),[
                'body'  => 'required'
            ]);
            $reply = $thread->addReply([
                'body'      => request('body'),
                'user_id'   => auth()->id()
            ]);
        }catch (Exception $exception){
            return response('sorry! your reply could not save at this time!',422);
        }


        if(\request()->expectsJson()){
            return $reply->load('owner');
        }

        return back()->with('flash','your reply has been left');
    }

    public function update(Reply $reply)
    {
//        $this->authorize('update',$reply);
        try{
            $this->validate(request(),[
                'body'  => 'required'
            ]);
            $reply->update(request(['body']));
        }catch (Exception $exception){
            return response(
                'sorry! your reply could not save at this time!',422
            );
        }

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
