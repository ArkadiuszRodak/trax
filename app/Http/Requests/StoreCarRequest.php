<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'year' => ['required', 'integer', 'min:1900', 'max:' . today()->format('Y')],
            'make' => ['required', 'string', 'min:2', 'max:100'],
            'model' => ['required', 'string', 'min:2', 'max:100'],
        ];
    }
}
