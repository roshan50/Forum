<?php
/**
 * Created by PhpStorm.
 * User: roshan
 * Date: 3/5/18
 * Time: 8:43 PM
 */

namespace App;
use Illuminate\Support\Facades\Redis;

class Trending
{
    public function get()
    {
        return array_map('json_decode',Redis::zrevrange($this->cacheKey(),0,4));
    }

    public function push($thread)
    {
        Redis::zincrby($this->cacheKey(),1,json_encode([
            'title' => $thread->title,
            'path' => $thread->path()
        ]));
    }

    public function cacheKey()
    {
        return 'trending_threads';
    }

    public function reset()
    {
        Redis::del($this->cacheKey());
    }
}