<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\ChatDetail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $chat; 
    public $content; 
    /**
     * Create a new event instance.
     */
    public function __construct(Chat $chat,ChatDetail $content)
    {
        $this->chat = $chat;
         $this->content = $content;
       
    }
    /**
     * Get the channels the event should broadcast on.
     *
     */
    public function broadcastOn(){
        return new PresenceChannel('comment'.$this->chat->id);
    }
   
    public function broadcastWith()
    {
        return [
            'sender_id' => $this->content->sender_id,
            'content' => $this->content->content,
            'userName' => $this->content->sender->name
        ];
    }
}
