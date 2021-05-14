<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TokenFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
