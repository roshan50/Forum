<?php

namespace App;

use function auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use function preg_replace;

class Reply extends Model
{
    use Favoritable,RecordActivity;

    protected $guarded=[];
    protected $with = ['owner','favorites'];
    protected $appends = ['favoritesCount','isFavorited'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply){
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply){
            $reply->thread->decrement('replies_count');
        });
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
        preg_match_all('/\@([\w\-]+)/',$this->body,$matches); //not space or .
        return $matches[1]; //without @
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/','<a href="/profiles/$1">$0</a>',$body);
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }
}
