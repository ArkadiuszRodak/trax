<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'before_or_equal:' . today()],
            'car_id' => ['required', 'integer', 'exists:cars,id'],
            'miles' => ['required', 'numeric', 'min:0.1'],
        ];
    }
}
