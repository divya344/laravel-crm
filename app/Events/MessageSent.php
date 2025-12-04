<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load(['sender', 'receiver']);
    }

    public function broadcastOn(): array
    {
        if ($this->message->receiver_id) {
            // direct chat between two users
            return [
                new PrivateChannel('chat.user.' . $this->message->receiver_id),
                new PrivateChannel('chat.user.' . $this->message->sender_id),
            ];
        }

        if ($this->message->channel) {
            return [new PrivateChannel('chat.channel.' . $this->message->channel)];
        }

        return [];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'body' => $this->message->body,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'channel' => $this->message->channel,
            'sender_name' => $this->message->sender?->name,
            'attachment_path' => $this->message->attachment_path,
            'created_at' => $this->message->created_at?->toDateTimeString(),
        ];
    }
}
