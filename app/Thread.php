<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use App\Notifications\YouWhereMentioned;
use App\Events\ThreadHasNewReply;
use function auth;
use function cache;
use function event;
use function get_class;
use Illuminate\Database\Eloquent\Model;
use function is_numeric;
use Laravel\Scout\Searchable;
use function preg_replace_callback;
use function sprintf;
use function str_slug;
use function strtolower;

class Thread extends Model
{
    use RecordActivity,Searchable;

    protected $guarded=[];
    protected $with=['creator','channel'];
    protected $appends=['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope('replyCount',function ($builder){
//            $builder->withCount('replies');
//        });
//        static::addGlobalScope('creator',function ($builder){
//            $builder->with('creator');
//        });
        static::deleting(function ($thread){
            $thread->replies->each->delete();
        });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug }/{$this->slug}";
    }
    public function replies(){
        return $this->hasMany(Reply::class);
    }
    public function creator(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply){
        $reply = $this->replies()->create($reply);

//        event(new ThreadHasNewReply($reply));

        $this->notifySubscribers($reply);
        $this->notifyMentioned($reply);
//        event(new ThreadHasNewReply($this,$reply));

        return $reply;
    }

    public function notifySubscribers($reply)
    {
//        $this->subscriptions->filter(function ($sub) use ($reply){
//            return $sub->user_id != $reply->user_id;
//        })
//        ->each->notify($reply);

//        $this->subscriptions
//            ->where('user_id' != $reply->user_id)
//            ->each
//            ->notify($reply);
//        ->each(function ($sub) use ($reply){
//            $sub->user->notify(new ThreadWasUpdated($this,$reply));
//        });

        foreach ($this->subscriptions as $subscription){
            if($subscription->user_id != $reply->user_id){
                $subscription->user->notify(new ThreadWasUpdated($this,$reply));
            }
        }
    }

    public function notifyMentioned($reply)
    {
        preg_match_all('/\@([^\s\.]+)/',$reply->body,$matches);
        $mentionedUsers = $matches[1];
        foreach ($mentionedUsers as $name){
            $user = User::whereName($name)->first();
            if($user){
                $user->notify(new YouWhereMentioned($reply));
            }
        }
    }

    public function scopeFilter($query,$filters){
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ? : auth()->id()
        ]);
        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id',$userId ? : auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id',auth()->id())
            ->exists();
    }

    public function hasUpdateFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);
        return $this->updated_at > cache($key);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        if(static::whereSlug($slug = str_slug($value))->exists()){
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug)
    {
        $max = static::whereSlug($this->title)->latest('id')->value('slug');
        if(is_numeric($max[-1])){
            return preg_replace_callback('/(\d+)$/',function ($matches){
                return $matches[1] + 1;
            },$max);
        }
        return "{$slug}-2";
    }

    public function lock()
    {
        $this->update(['locked' => 1]);
    }

    public function unlock()
    {
        $this->update(['locked' => 0]);
    }

    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->path()];
    }
}
