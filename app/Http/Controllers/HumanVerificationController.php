<?php

namespace App\Http\Controllers;

use App\Models\Human;
use Illuminate\Http\Request;
use SjorsO\Gobble\Facades\Gobble;

class HumanVerificationController
{
    public function index()
    {
        return view('human-verification');
    }

    public function post(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => 'required|string',
        ]);

        $response = Gobble::post('https://www.google.com/recaptcha/api/siteverify', ['query' => [
            'secret' => config('keys.recaptcha_secret_key'),
            'response' => $request->get('g-recaptcha-response'),
            'remoteip' => $request->getClientIp(),
        ]]);

        $success = strpos($response->getBody()->getContents(), '"success": true') !== false;

        if (! $success) {
            return back();
        }

        $sessionId = session()->getId();

        if (! Human::isReal($sessionId)) {
            Human::create(['session_id' => $sessionId]);
        }

        $redirectUrl = session()->pull('human-redirect') ?: route('home');

        return redirect($redirectUrl);
    }
}
