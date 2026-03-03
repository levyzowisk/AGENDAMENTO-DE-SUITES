<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(RolePermissionSeeder::class);
	}

	public function test_updates_user_successfully(): void
	{
		$user = User::factory()->create();
		$user->assignRole('admin');

		$payload = [
			'name' => 'Nome Atualizado',
			'role' => 'operator',
		];

		$response = $this->patchJson("/api/users/{$user->id}", $payload);

		$response->assertStatus(200)
			->assertJsonPath('data.id', $user->id)
			->assertJsonPath('data.name', 'Nome Atualizado')
			->assertJsonPath('data.role.name', 'operator');

		$this->assertDatabaseHas('users', [
			'id' => $user->id,
			'name' => 'Nome Atualizado',
		]);
	}

	public function test_returns_404_for_nonexistent_user(): void
	{
		$response = $this->patchJson('/api/users/9999', ['name' => 'Qualquer']);

		$response->assertStatus(404);
	}
}
