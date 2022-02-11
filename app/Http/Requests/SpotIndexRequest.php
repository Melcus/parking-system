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
            'datetime_range.start' => ['sometimes', 'date', 'after_or_equal:now'],
            'datetime_range.end'   => ['sometimes', 'date', 'after:start'],
            'size'                 => ['nullable', 'string', 'in:small,medium,large'],
            'attributes'           => ['sometimes', 'array'],
            'attributes.*'         => ['required', 'string', 'in:electric,for_women,handicapped,with_kids']
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->get('start') && $this->get('end')) {
            return $this->merge([
                'datetime_range' => [
                    'start' => $this->get('start'),
                    'end'   => $this->get('end'),
                ]
            ]);
        }

        return $this;
    }
}
