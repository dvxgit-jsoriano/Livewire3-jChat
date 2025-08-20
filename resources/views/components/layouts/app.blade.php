<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') ?? 'Page Title' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="min-h-screen bg-gray-100" x-data="{ mobileMenu: false }">
        {{-- Top Navigation Bar --}}
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    {{-- Logo and Title --}}
                    <div class="flex items-center">
                        <img src="https://sesystems.com.sa/wp-content/uploads/2025/02/diavox.png" alt="Logo"
                            class="h-8 w-auto">
                        <span class="ml-2 text-xl font-semibold">JChats</span>
                    </div>

                    {{-- Mobile Menu Button --}}
                    <div class="sm:hidden flex items-center">
                        <button @click="mobileMenu=true" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>

                    {{-- Desktop Navigation Menu --}}
                    <div class="hidden sm:flex sm:items-center space-x-8">
                        <a href="{{ route('contacts') }}" class="text-gray-700 hover:text-gray-900">Contacts</a>
                        <a href="{{ route('chats') }}" class="text-gray-700 hover:text-gray-900">Chats</a>
                    </div>

                    {{-- User Dropdown --}}
                    <div class="hidden sm:flex items-center">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open=!open"
                                class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none cursor-pointer">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                                <i class="fas fa-user"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer w-full text-left">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Mobile Menu Drawer --}}
        <div>
            <div x-show="mobileMenu" class="fixed inset-0 z-50 bg-gray-300/50" @click="mobileMenu=false">
            </div>

            <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="fixed top-0 right-0 z-50 w-64 h-full bg-white shadow-lg">

                {{-- Close Button --}}
                <div class="p-4 flex justify-end">
                    <button @click="mobileMenu=false" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                {{-- Mobile Menu Items --}}
                <div class="px-4 py-2 space-y-4">
                    <a href="{{ route('contacts') }}" class="block text-gray-700 hover:text-gray-900">Contacts</a>
                    <a href="{{ route('chats') }}" class="block text-gray-700 hover:text-gray-900">Chats</a>
                    <hr class="my-4">
                    <a href="#" class="block text-gray-700 hover:text-gray-900">Profile</a>
                    <a href="#" class="block text-gray-700 hover:text-gray-900">Settings</a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        {{-- CSRF Token for Logout --}}
                        @csrf
                        <button type="submit" class="block text-gray-700 hover:text-gray-900">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{ $slot }}

    </div>
</body>

</html>
