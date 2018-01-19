<?php

namespace App;


trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class,'favorited');
    }

    public function favorite()
    {
        $attr = ['user_id' => auth()->id()];
        if(! $this->favorites()->where($attr)->exists()){
            return $this->favorites()->create($attr);
        }
    }

    public function isFavorited(){
        return !! $this->favorites->where('user_id',auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}