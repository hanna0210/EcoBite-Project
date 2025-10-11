<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseLivewireComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserLoginLivewire extends BaseLivewireComponent
{
    public $email;
    public $password;
    public $remember = false;

    public function loadAccount(int $type = 0)
    {
        if ($type == 0) {
            $this->email = "client@demo.com";
        }
        $this->password = "password";
    }

    public function login()
    {
        $this->validate(
            [
                "email" => "required|email|exists:users",
                "password" => "required|string",
            ],
            [
                "email.exists" => __("Email not associated with any account")
            ]
        );

        //
        $user = User::where('email', $this->email)->first();

        // Only allow client/driver roles for user login
        if (!$user->hasAnyRole('client', 'driver')) {
            $this->showErrorAlert(__("Unauthorized Access. This login is for customers only."));
            return;
        } else if (!$user->is_active) {
            $this->showErrorAlert(__("Account is not active. Please contact us"));
            return;
        }

        if (Hash::check($this->password, $user->password) && Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            //
            // For users, redirect to a user dashboard or home page
            // You can modify this route based on your application's user flow
            return redirect()->intended('/');
        } else {
            $this->showErrorAlert(__("Invalid Credentials. Please check your credentials and try again"));
        }
    }

    public function render()
    {
        return view('livewire.auth.user-login')->layout('layouts.guest');
    }
}
