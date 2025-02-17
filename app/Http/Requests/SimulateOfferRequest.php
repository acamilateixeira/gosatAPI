<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimulateOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cpf' => ['required', 'string', 'digits:11'],
            'institution_id' => ['required', 'integer', 'exists:institutions,id'],
            'codModalidade' => ['required', 'string'],
        ];
    }
}