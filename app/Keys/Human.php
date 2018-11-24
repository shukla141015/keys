<?php

namespace App\Keys;

class Human
{
    public function isReal()
    {
        return (bool) session()->get('is-human');
    }

    public function verifyCurrentUser()
    {
        session()->put('is-human', true);
    }

    public function putRedirectUrl($url)
    {
        session()->put('human-redirect', $url);
    }

    public function pullRedirectUrl()
    {
        return session()->pull('human-redirect') ?: route('home');
    }
}
