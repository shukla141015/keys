<?php

namespace App\Http\Rules;

use App\Keys\PageNumbers\BitcoinPageNumber;
use Illuminate\Contracts\Validation\Rule;

class ValidBitcoinPageNumber implements Rule
{
    public function passes($attribute, $value)
    {
        $btcPageNumber = new BitcoinPageNumber($value);

        return $btcPageNumber->isValid();
    }

    public function message()
    {
        return 'Not a valid bitcoin page number.';
    }
}
