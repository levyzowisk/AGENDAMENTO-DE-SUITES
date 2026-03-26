<?php

declare(strict_types=1);

namespace App\Http\Requests\Suite;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSuiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type_suite' => ['sometimes', 'string', 'max:255'],
            'amount_per_hour' => ['sometimes', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'type_suite.string' => 'O tipo da suíte deve ser uma string.',
            'type_suite.max' => 'O tipo da suíte deve ter no máximo 255 caracteres.',
            'amount_per_hour.numeric' => 'O valor por hora deve ser um número.',
        ];
    }
}
