<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleting implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $id;
    protected $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $message)
    {
        $this->message = $message;
        $this->id = $id;
    }

    public function broadcastWith()
    {
        return [
            'id' =>  $this->id,
            'message' => $this->message,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('pusher-delete');
    }

    /**
     * Broadcasting with the name of event
     *
     * @return void
     */
    public function broadcastAs()
    {
        return 'my-event';
    }
}
