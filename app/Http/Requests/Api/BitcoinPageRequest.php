<?php

namespace App\Http\Requests\Api;

use App\Http\Rules\ValidBitcoinPageNumber;
use Illuminate\Foundation\Http\FormRequest;

class BitcoinPageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page_number' => ['required', 'string', 'max:255', new ValidBitcoinPageNumber],
            'empty'       => 'required|boolean',
        ];
    }

    public function getPageNumber(): string
    {
        return $this->get('page_number');
    }

    public function isEmptyPage(): bool
    {
        return $this->get('empty');
    }
}
