<?php

namespace App;

use function auth;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable,RecordActivity;

    protected $guarded=[];
    protected $with = ['owner','favorites'];

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
}
