<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email'
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function read($thread)
    {
        cache()->forever($this->visitedThreadCacheKey($thread),Carbon::now());
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s",$this->id,$thread->id);
    }

//    public function avatar()
//    {
//        return asset($this->avatar_path ? 'storage/'.$this->avatar_path  : 'images/avatars/default.png');
//    }

    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? 'storage/'.$avatar  : 'images/avatars/default.png');
    }
}
