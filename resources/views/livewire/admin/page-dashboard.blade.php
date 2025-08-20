{{-- Chat Interface --}}
<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-4" x-data="{ mobileListOpen: false }">
    <div class="flex h-[calc(100vh-8rem)] bg-white rounded-lg shadow-sm relative">
        {{-- Chat List (responsive) --}}
        <div class="w-80 border-r border-gray-200 hidden md:block"
            :class="{ 'hidden md:block': !mobileListOpen, 'absolute inset-0 z-10 bg-white': mobileListOpen }">
            <div class="p-4">
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
                {{-- Chat List Items --}}
                <div class="p-4 hover:bg-gray-50 cursor-pointer">
                    <div class="font-semibold">John Doe</div>
                    <div class="text-sm text-gray-500">Latest message...</div>
                </div>
                {{-- Add more chat items here --}}
            </div>
        </div>

        {{-- Chat Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Chat Header --}}
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
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
            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                {{-- Received Message --}}
                <div class="flex items-start">
                    <div class="bg-gray-100 rounded-lg p-3 max-w-[70%]">
                        <p>This is a received message</p>
                    </div>
                </div>

                {{-- Sent Message --}}
                <div class="flex items-start justify-end">
                    <div class="bg-blue-500 text-white rounded-lg p-3 max-w-[70%]">
                        <p>This is a sent message</p>
                    </div>
                </div>
            </div>

            {{-- Message Input --}}
            <div class="p-4 border-t border-gray-200">
                <div class="flex space-x-2">
                    <input type="text" placeholder="Type your message..."
                        class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Send
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
