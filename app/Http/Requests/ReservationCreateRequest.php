<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start'   => ['required', 'date', 'after_or_equal:now'],
            'end'     => ['required', 'date', 'after:start'],
            'spot_id' => ['required'],
        ];
    }
}
