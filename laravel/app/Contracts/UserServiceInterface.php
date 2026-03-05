<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
	public function listAll(): Collection;

	public function getById(int $id): User;

	public function create(array $data): User;

	public function update(int $id, array $data): User;

	public function delete(int $id): bool;
}
