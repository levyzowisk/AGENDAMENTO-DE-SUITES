<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\UserRepositoryInterface;
use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
	public function __construct(
		private readonly UserRepositoryInterface $userRepository
	) {
	}

	public function listAll(): Collection
	{
		return $this->userRepository->all();
	}

	public function getById(int $id): User
	{
		$user = $this->userRepository->findById($id);

		if (!$user) {
			throw new ModelNotFoundException("Usuário com id {$id} não encontrado.");
		}

		return $user;
	}

	public function create(array $data): User
	{
		$role = $data['role'] ?? null;

		$userData = [
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		];

		$user = $this->userRepository->create($userData);

		if ($role) {
			$user->assignRole($role);
		}

		return $user->load('roles.permissions');
	}

	public function update(int $id, array $data): User
	{
		$user = $this->getById($id);

		$updateData = array_filter([
			'name' => $data['name'] ?? null,
			'email' => $data['email'] ?? null,
		], fn($v) => !is_null($v));

		if (!empty($data['password'])) {
			$updateData['password'] = Hash::make($data['password']);
		}

		$user = $this->userRepository->update($user, $updateData);

		if (isset($data['role'])) {
			$user->syncRoles($data['role']);
		}

		return $user->load('roles.permissions');
	}

	public function delete(int $id): bool
	{
		$user = $this->getById($id);

		return $this->userRepository->delete($user);
	}
}
