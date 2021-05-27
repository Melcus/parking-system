<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpotIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start' => ['sometimes', 'date'],
            'end'   => ['sometimes', 'date']
        ];
    }
}
