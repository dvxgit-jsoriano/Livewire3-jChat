<?php

namespace App\Livewire\Admin;

use App\Events\NewChatRoom;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PageDashboard extends Component
{
    protected $listeners = ['refresh-chat-list' => '$refresh'];

    public $rooms = [];
    public $showCreateModal = false; // <-- Add this
    public $email; // <-- since you bind wire:model.defer="email"

    public function mount()
    {
        $this->loadRooms();
    }

    public function loadRooms()
    {
        $user = Auth::user();

        if (!$user) {
            $this->rooms = [];
            return;
        }

        $this->rooms = $user->chatRooms()
            ->with(['latestMessage.sender', 'users'])
            ->get()
            ->map(function ($room) use ($user) {
                $otherUser = !$room->is_group
                    ? $room->users->where('id', '!=', $user->id)->first()
                    : null;

                return [
                    'id' => $room->id,
                    'name' => $room->is_group ? $room->name : ($otherUser?->name ?? 'Unknown'),
                    'latest_message' => $room->latestMessage?->message ?? 'No messages yet',
                    'latest_time' => $room->latestMessage?->created_at?->diffForHumans(),
                ];
            });
    }

    public function createRoom()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = Auth::user();
        $otherUser = \App\Models\User::where('email', $this->email)->first();

        // Check if a room already exists between the two users
        $room = ChatRoom::where('is_group', false)
            ->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->whereHas('users', function ($q) use ($otherUser) {
                $q->where('users.id', $otherUser->id);
            })
            ->first();

        // If not, create a new one
        if (!$room) {
            $room = ChatRoom::create([
                'is_group' => false,
                'name' => $otherUser->name, // 👈 put the user's name here
            ]);
            $room->users()->attach([$user->id, $otherUser->id]);
        }

        // Send event to other user
        event(new NewChatRoom($room, $otherUser));
        //broadcast(new NewChatRoom($room, $otherUser))->toOthers();
        //NewChatRoom::dispatch($room, $otherUser);

        // Refresh rooms list
        $this->loadRooms();

        // Reset modal
        $this->reset(['showCreateModal', 'email']);
    }

    public function render()
    {
        return view('livewire.admin.page-dashboard', ['rooms' => ChatRoom::latest()->get()]);
    }
}
