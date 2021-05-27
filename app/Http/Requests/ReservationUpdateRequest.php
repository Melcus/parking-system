<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route()->reservation);
    }

    public function rules(): array
    {
        return [
            'start' => ['required', 'date', 'after_or_equal:now'],
            'end'   => ['required', 'date', 'after:start'],
        ];
    }
}
