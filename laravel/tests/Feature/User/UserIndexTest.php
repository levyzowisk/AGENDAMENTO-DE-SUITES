<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class UserIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function testReturnsEmptyListWhenNoUsers(): void
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJson(['data' => []])
        ;
    }

    public function testReturnsListOfUsersWithRolesAndPermissions(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'role' => [
                            'id',
                            'name',
                            'permissions' => [
                                '*' => ['id', 'name'],
                            ],
                        ],
                    ],
                ],
            ])
        ;
    }
}
