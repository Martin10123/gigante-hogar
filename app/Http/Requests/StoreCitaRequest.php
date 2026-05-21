<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descripcion' => ['required', 'string', 'max:255'],
            'fecha' => ['required', 'date', 'after:today'],
            'cupos_totales' => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }
}