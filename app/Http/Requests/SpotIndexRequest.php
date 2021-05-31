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
            'start' => ['sometimes', 'date', 'after_or_equal:now'],
            'end'   => ['sometimes', 'date', 'after:start']
        ];
    }
}
