<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		$userId = (int) $this->route('user');

		return [
			'name' => ['sometimes', 'string', 'max:255'],
			'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($userId)],
			'password' => ['sometimes', 'string', 'min:8'],
			'role' => ['sometimes', 'string', 'exists:roles,name'],
		];
	}

	public function messages(): array
	{
		return [
			'email.email' => 'O e-mail deve ser válido.',
			'email.unique' => 'Este e-mail já está em uso.',
			'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
			'role.exists' => 'O cargo informado não existe.',
		];
	}
}
