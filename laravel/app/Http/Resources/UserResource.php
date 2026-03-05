<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		$role = $this->roles->first();

		return [
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'role' => $role ? [
				'id' => $role->id,
				'name' => $role->name,
				'permissions' => $role->permissions->map(fn($p) => [
					'id' => $p->id,
					'name' => $p->name,
				])->values(),
			] : null,
		];
	}
}
