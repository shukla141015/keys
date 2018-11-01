<?php

namespace App\Http\Controllers;

use App\Models\Human;

class HumanVerificationController
{
    public function index()
    {
        return view('human-verification');
    }

    public function post()
    {
        Human::create([
            'session_id' => session()->getId(),
        ]);

        $redirectUrl = session()->pull('human-redirect') ?: route('home');

        return redirect($redirectUrl);
    }
}
