<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $errorMessage = '';

    #[Layout('components.layouts.auth')]
    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 2. Attempt to authenticate the user.
        if (!Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            // If authentication fails, set a general error message.
            $this->errorMessage = trans('auth.failed');

            // It's a good practice to log the failed attempt as well.
            // Log::warning('Failed login attempt for email: ' . $this->email);
            return;
        }

        // 4. Regenerate the session to prevent session fixation attacks.
        request()->session()->regenerate();

        // 5. Redirect the user to the intended dashboard or home page.
        return redirect()->intended('admin/dashboard');
    }
}
