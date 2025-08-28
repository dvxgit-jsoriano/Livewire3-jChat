<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $errorMessage = '';

    #[Layout('components.layouts.auth')]
    public function render()
    {
        return view('livewire.auth.register');
    }

    public function register()
    {
        try {
            // 1. Validate input
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ]);

            // 2. Create the user
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            // 3. Auto-login the user
            Auth::login($user);

            // 4. Regenerate session
            request()->session()->regenerate();

            // 5. Redirect to dashboard
            return redirect()->intended('admin/dashboard');
        } catch (Exception $e) {
            // Handle unexpected errors
            $this->errorMessage = 'Something went wrong. Please try again later.';
        }
    }
}
