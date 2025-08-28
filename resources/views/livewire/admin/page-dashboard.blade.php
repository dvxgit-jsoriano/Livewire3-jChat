{{-- Chat Interface --}}
<div class="max-w-7xl mx-auto border-8 border-green-950 shadow-2xl mt-2 rounded-3xl" x-data="{ mobileListOpen: false }">
    <div class="flex h-[calc(100vh-6rem)] bg-white rounded-2xl shadow-sm relative">
        {{-- Chat List (responsive) --}}
        <div class="w-80 border-gray-200 rounded-2xl hidden md:block border-e-2 shadow"
            :class="{ 'hidden md:block': !mobileListOpen, 'absolute inset-0 z-10 bg-white': mobileListOpen }">
            <div class="p-4 border-b border-b-gray-300 rounded-tl-2xl">
                <div class="relative z-10 flex items-center">
                    <input type="text" placeholder="Search conversations..."
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 absolute right-10 top-3 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    {{-- Close button (visible only on mobile) --}}
                    <button class="hidden ml-2" :class="{ 'hidden': !mobileListOpen, 'block': mobileListOpen }"
                        @click="mobileListOpen = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="overflow-y-auto h-full">
                <div class="flex justify-center items-center border-b border-b-gray-300">
                    <button wire:click="$set('showCreateModal', true)"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 my-4">
                        Start New Conversation
                    </button>
                </div>

                @forelse($rooms as $room)
                    <div wire:click="selectRoom({{ $room['id'] }})"
                        class="p-4 hover:bg-gray-50 cursor-pointer border-b border-b-gray-300
                        {{ $currentRoomId === $room['id'] ? 'bg-blue-50' : '' }}">
                        <div class="font-semibold">{{ $room['name'] }}</div>
                        <div class="text-sm text-gray-500 truncate">
                            {{ $room['latest_message'] }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $room['latest_time'] }}
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-gray-500">No conversations yet.</div>
                @endforelse
            </div>


            <!-- Modal Background -->
            <div class="fixed inset-0 z-10 overflow-y-auto h-full shadow-2xl" style="background-color: rgba(0,0,0,0.4);"
                x-show="$wire.showCreateModal" x-on:click.self="$wire.showCreateModal = false">

                <!-- Modal Content -->
                <div
                    class="relative top-20 mx-auto w-[300px] sm:w-96 p-5 border-2 border-green-950 shadow-2xl rounded-xl bg-white">
                    <!-- Modal Header -->
                    <div class="text-xl font-semibold mb-4">
                        Create New Conversation
                    </div>

                    <!-- Modal Body -->
                    <div class="mt-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            User Email
                        </label>
                        <input type="email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            wire:model.defer="email">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="mt-6 flex justify-end space-x-2">
                        <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                            wire:click="$set('showCreateModal', false)">
                            Cancel
                        </button>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                            wire:click="createRoom">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chat Content --}}
        <div class="flex-1 flex flex-col w-full">
            {{-- Chat Header --}}
            <div class="p-4 border-b border-gray-200 flex justify-between items-center rounded-t-2xl">
                <div class="flex items-center">
                    <button class="md:hidden mr-2" @click="mobileListOpen = true">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="font-semibold">Current Chat</div>
                </div>
            </div>

            {{-- Chat Messages --}}
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
                @foreach ($messages as $message)
                    @if ($message['user_id'] === auth()->id())
                        <div class="text-right">
                            <p class="inline-block bg-blue-500 text-white px-3 py-1 rounded-lg">
                                {{ $message['message'] }}
                            </p>
                            <span class="text-xs text-gray-500 block">
                                {{ $message['created_at'] }}
                            </span>
                        </div>
                    @else
                        <div class="text-left">
                            <p class="inline-block bg-gray-200 px-3 py-1 rounded-lg">
                                {{ $message['message'] }}
                            </p>
                            <span class="text-xs text-gray-500 block">
                                {{ $message['created_at'] }}
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Message Input --}}
            <div class="p-4 border-t border-gray-200">
                <div class="flex space-x-2">
                    <input type="text" wire:model="messageText" wire:keydown.enter="sendMessage"
                        placeholder="Type your message..."
                        class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button wire:click="sendMessage"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Send
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let userId = @json(auth()->id());
            let currentRoomId = null;

            // Listen for new chat rooms
            window.Echo.private(`user.${userId}`)
                .listen('.new.chat.room', (e) => {
                    console.log("🔥 New chat room event received:", e);

                    // trigger a Livewire refresh
                    Livewire.dispatch('refresh-chat-list');
                });

            // when Livewire tells us the selected room changed
            Livewire.on('room-selected', (event) => {
                const roomId = event.roomId;

                // subscribe to the new room
                window.Echo.private(`chat.${roomId}`)
                    // must match broadcastAs(): 'new.message'
                    .listen('.new.message', (e) => {
                        // I want to call the loadMessage() method in Livewire class of this PageDashboard
                        Livewire.dispatch('chat-message-received', e);

                        //Livewire.dispatch('chat-scrolled');
                    });
            });
        });

        document.addEventListener('livewire:init', function() {
            console.log("🚀 Livewire is loaded");
            Livewire.on('chat-scrolled', () => {
                Livewire.hook('morphed', ({
                    el,
                    component
                }) => {
                    //console.log(component);
                    console.log("🔽 Scrolling to bottom");
                    let container = document.getElementById('chat-messages');
                    if (container) {
                        container.scrollTo({
                            top: container.scrollHeight,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</div>
