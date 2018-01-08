<?php

use Faker\Generator as Faker;
use Faker\Factory as FactoryFaker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$localisedFaker = FactoryFaker::create("fa_IR");

$factory->define(App\User::class, function (Faker $faker) use ($localisedFaker){
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Thread::class, function (Faker $faker) use ($localisedFaker){
    return [
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        },
        'channel_id'=> function(){
            return factory('App\Channel')->create()->id;
        },
        'title' => $localisedFaker->name(),
        'body' => $localisedFaker->realText()
    ];
});

$factory->define(App\Channel::class, function (Faker $faker) use ($localisedFaker){
    $name = $localisedFaker->name();
    return [
        'name' => $name,
        'slug' => $name
    ];
});

$factory->define(App\Reply::class, function (Faker $faker) use ($localisedFaker){
    return [
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        },
        'thread_id'=> function(){
            return factory('App\Thread')->create()->id;
        },
        'body' => $localisedFaker->realText()
    ];
});
