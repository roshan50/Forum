<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
//        \View::share('channels',Channel::all());
        \View::composer('*',function ($view){
            $channels = Cache::rememberForEver('channels',function (){
                return Channel::all();
            });
            $view->with('channels',$channels);
        });
    }

    /**
     * Register any application services.
     *
     * @return voidt
     */
    public function register()
    {
        if($this->app->isLocal()){
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
