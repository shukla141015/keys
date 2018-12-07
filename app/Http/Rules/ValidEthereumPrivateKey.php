<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEthereumPrivateKey implements Rule
{
    public function passes($attribute, $value)
    {
        return (bool) preg_match('/^[0-9a-f]{64}$/', $value);
    }

    public function message()
    {
        return 'Not a valid Ethereum private key.';
    }
}
