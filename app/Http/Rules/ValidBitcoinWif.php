<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidBitcoinWif implements Rule
{
    public function passes($attribute, $value)
    {
        // The Bitcoin WIF is a base58 string, it seems to usually be 51 characters long.
        return (bool) preg_match('/^[123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz]{40,60}$/', $value);
    }

    public function message()
    {
        return 'Not a valid Bitcoin wallet-identifier-format.';
    }
}
