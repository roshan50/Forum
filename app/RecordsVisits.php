<?php
/**
 * Created by PhpStorm.
 * User: roshan
 * Date: 3/8/18
 * Time: 10:44 PM
 */

namespace App;
use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());
        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;
    }

    public function reset()
    {
        Redis::del($this->visitsCacheKey());
        return $this;
    }

    public function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}