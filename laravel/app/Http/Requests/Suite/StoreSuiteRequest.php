<?php

declare(strict_types=1);

namespace App\Http\Requests\Suite;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type_suite' => ['required', 'string', 'max:255'],
            'amount_per_hour' => ['required', 'numeric'],
            'available_count' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'type_suite.required' => 'O tipo da suíte é obrigatório.',
            'type_suite.string' => 'O tipo da suíte deve ser uma string.',
            'type_suite.max' => 'O tipo da suíte deve ter no máximo 255 caracteres.',
            'amount_per_hour.required' => 'O valor por hora é obrigatório.',
            'amount_per_hour.numeric' => 'O valor por hora deve ser um número.',
            'available_count.required' => 'A quantidade disponível é obrigatória.',
            'available_count.integer' => 'A quantidade disponível deve ser um número inteiro.',
        ];
    }
}