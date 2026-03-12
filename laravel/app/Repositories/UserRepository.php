<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::with('roles.permissions')->get();
    }

    public function findById(int $id): ?User
    {
        return User::with('roles.permissions')->find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->fill($data)->save();

        return $user->fresh(['roles.permissions']);
    }

    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }
}
