<?php

namespace App\Listeners;

use App\Events\ChatCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateChatNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ChatCreated  $event
     * @return void
     */
    public function handle(ChatCreated $event)
    {
        //
    }
}
