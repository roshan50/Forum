<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use App\Filters\ThreadFilters;
use App\User;
use function array_map;
use function cache;
use Carbon\Carbon;
use function collect;
use function config;
use Illuminate\Http\Request;
use function auth;
use function back;
use function compact;
use function json_decode;
use function json_encode;
use Mockery\Exception;
use function redirect;
use function response;
use function str_slug;
use function view;
use App\Trending;
use Zttp\Zttp;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel,ThreadFilters $filters,Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if(\request()->wantsJson()){
            return $threads;
        }

        $trending = $trending->get();
        return view('threads.index',compact('threads','trending'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(/*Recaptcha $recaptcha*/)
    {
        request()->validate([
            'title' => 'required',
            'body'  => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

//        $response = Zttp::asFormParams()->post('https://www.google.com/recaptcha/api/siteverify',[
//            'secret' => config('services.recaptcha.secret'),
//            'response' => request()->input('g-recaptcha-response'),
//            'remoteip' => $_SERVER['REMOTE_ADDR']
//        ]);

//        if(! $response->json()['success']){
//            throw new Exception('recaptcha failed');
//        }

        $thread = Thread::create([
           'user_id' => auth()->id(),
           'channel_id' => request('channel_id'),
           'title'   => request('title'),
           'body'    => request('body'),
            'slug'   =>str_slug(\request('title'))
        ]);
        return redirect($thread->path())
            ->with('flash','بحث شما با موفقیت ایجاد شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId,Thread $thread,Trending $trending)
    {
        if(auth()->check()){
            auth()->user()->read($thread);
        }

        $trending->push($thread);
        $thread->increment('visits');

        return view('threads.show',compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update($channel, Thread $thread)
    {
        $this->authorize('update',$thread);
        $data = \request()->validate([
            'title' => 'required',
            'body'  => 'required',
        ]);
        $thread->update($data);
        return $thread;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel,Thread $thread)
    {
        $this->authorize('update',$thread);
//        $thread->replies()->delete();
        $thread->delete();
        if(\request()->wantsJson()){
            return response([],204);
        }
        return redirect('/threads');

    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads =  Thread::latest()->filter($filters);
        if($channel->exists){
            $threads->where('channel_id',$channel->id);
        }

        return $threads->paginate(5);
    }
}
