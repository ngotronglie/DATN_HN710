<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     */
    public function broadcastOn()
    {
        return new Channel('notifications');
    }
    public function broadcastAs()
    {
        return 'new-message';
    }
    public function broadcastWith()
    {
        return [
            'sender_id' => $this->message->sender_id,
            'content' => $this->message->content,
            'userName' => $this->message->sender->name,
            'image'=>$this->message->sender->avatar,
            'date'=>$this->message->created_at,
        ];
    }
}
