<?php

namespace App\Http\Controllers\traits;

use Illuminate\Support\Facades\Auth;

trait Logout
{
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login.page')
            ->with('message', 'Logged out.');
    }
}
