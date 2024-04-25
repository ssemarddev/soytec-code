<?php

namespace App\Listeners;

use App\Events\MessageDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteMessageNotification implements ShouldQueue
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
     * @param  \App\Events\MessageDeleted  $event
     * @return void
     */
    public function handle(MessageDeleted $event)
    {
        //
    }
}
