<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSend implements ShouldBroadcast
{
    use Dispatchable;

    /**
     * The message instance.
     *
     * @var \App\Models\Message
     */
    public $message;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Storage::put("example.txt", json_encode($this->message));
        //return new PrivateChannel('chat-channel');
        return ['chat-channel'];
    }

    public function broadcastAs()
    {
        return 'MessageSended';
    }
}
