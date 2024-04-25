<?php

namespace App\Listeners;

use App\Events\ChatDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteChatNotification implements ShouldQueue
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
     * @param  \App\Events\ChatDeleted  $event
     * @return void
     */
    public function handle(ChatDeleted $event)
    {
        //
    }
}
