<?php

namespace App\Listeners;

use App\Events\MessageSend;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMessageNotification implements ShouldQueue
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
     * @param  \App\Events\MessageSend  $event
     * @return void
     */
    public function handle(MessageSend $event)
    {
        //
    }
}
