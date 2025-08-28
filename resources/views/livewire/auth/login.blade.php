<div class="bg-green-900 h-screen flex items-center justify-center text-sm">
    <div class="mx-2 w-full min-w-[340px] max-w-[480px] bg-white p-4 rounded-lg shadow-lg">
        @if ($errorMessage)
            <!-- Alert Error -->
            <div class="bg-red-200 px-3 py-4 my-3 rounded-md items-center mx-none max-w-lg flex">
                <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                    <path fill="currentColor"
                        d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                    </path>
                </svg>
                <span class="text-red-800"> {{ $errorMessage }}</span>
            </div>
        @endif

        {{-- <div class="flex items-center justify-center mb-4">
            <img src="https://sesystems.com.sa/wp-content/uploads/2025/02/diavox.png" alt="Logo" class="w-16 h-16">
        </div> --}}
        <h1 class="text-center text-lg font-semibold mb-4">Login Form</h1>
        <p class="text-center text-gray-600 mb-6">Please enter your credentials to login.</p>

        <form wire:submit.prevent="login">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" wire:model.lazy="email"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" wire:model.lazy="password"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                    required>
            </div>
            <button type="submit"
                class="w-full bg-green-600 text-white p-2 rounded-md hover:bg-green-700 transition duration-200 cursor-pointer">Login</button>
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-green-600 hover:underline">Don't have an account?
                    Register</a>
            </div>
        </form>



    </div>
</div>
