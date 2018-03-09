<?php

namespace App\Http\Middleware;

use Closure;
use function redirect;

class RedirectIfEmailNotConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! $request->user()->confirmed){
            return redirect('/threads')->with('flash','you must first confirmed your email address!');
        }
        return $next($request);
    }
}
