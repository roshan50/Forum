<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\YouWhereMentioned;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
//        $mentionedUsers = $event->reply->mentionedUsers();
        preg_match_all('/\@([^\s\.]+)/',$this->body,$matches);
        $mentionedUsers = $matches[1];
        foreach ($mentionedUsers as $name){
            $user = User::whereName($name)->first();
            if($user){
                $user->notify(new YouWhereMentioned($event->reply));
            }
        }
    }
}
