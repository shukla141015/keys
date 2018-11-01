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
        $sessionId = session()->getId();

        if (! Human::isReal($sessionId)) {
            Human::create(['session_id' => $sessionId]);
        }

        $redirectUrl = session()->pull('human-redirect') ?: route('home');

        return redirect($redirectUrl);
    }
}
