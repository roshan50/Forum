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

    public function unfavorite()
    {
        $attributes = ['user_id'=>auth()->id()];
        $this->favorites()->where($attributes)->get()->each->delete(); //get()->each =>for delete activities
    }

    public function isFavorited(){
        return !! $this->favorites->where('user_id',auth()->id())->count();
    }

    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}