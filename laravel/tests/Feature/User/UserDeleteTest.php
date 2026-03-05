<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserDeleteTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(RolePermissionSeeder::class);
	}

	public function test_deletes_user_successfully(): void
	{
		$user = User::factory()->create();
		$user->assignRole('operator');

		$response = $this->deleteJson("/api/users/{$user->id}");

		$response->assertStatus(200)
			->assertJson(['id' => $user->id]);

		$this->assertDatabaseMissing('users', ['id' => $user->id]);
	}

	public function test_returns_404_for_nonexistent_user(): void
	{
		$response = $this->deleteJson('/api/users/9999');

		$response->assertStatus(404);
	}
}
