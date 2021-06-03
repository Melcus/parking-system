<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class CalculatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('view', Reservation::find($this->get('reservation_id')));
    }

    public function rules(): array
    {
        return [
            'reservation_id' => ['required']
        ];
    }
}
