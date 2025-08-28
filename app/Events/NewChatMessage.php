<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $payload; // <= array, not a model

    public function __construct(ChatMessage $message)
    {
        // Keep it minimal. If you need sender later, you can add it here.
        $this->payload = [
            'id'           => $message->id,
            'chat_room_id' => $message->chat_room_id,
            'user_id'      => $message->user_id,
            'message'      => $message->message,
            'created_at'   => optional($message->created_at)->toISOString(),
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->payload['chat_room_id']);
    }

    // Match your JS listener: .listen('.new.message', ...)
    public function broadcastAs(): string
    {
        return 'new.message';
    }

    // Always return an array — this avoids array_merge() crashes
    public function broadcastWith(): array
    {
        return $this->payload;
    }
}
