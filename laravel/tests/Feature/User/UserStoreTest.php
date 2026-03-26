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
class UserStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function testCreatesUserSuccessfully(): void
    {
        $payload = [
            'name' => 'Fulano de Tal',
            'email' => 'fulano@example.com',
            'password' => 'senha1234',
            'role' => 'admin',
        ];

        $response = $this->postJson('/api/users', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'role'],
            ])
            ->assertJsonPath('data.name', 'Fulano de Tal')
            ->assertJsonPath('data.email', 'fulano@example.com')
            ->assertJsonPath('data.role.name', 'admin')
        ;

        $this->assertDatabaseHas('users', ['email' => 'fulano@example.com']);
    }

    public function testValidationFailsWithMissingRequiredFields(): void
    {
        $response = $this->postJson('/api/users', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password', 'role'])
        ;
    }

    public function testValidationFailsWithDuplicateEmail(): void
    {
        User::factory()->create(['email' => 'duplicado@example.com']);

        $payload = [
            'name' => 'Outro Nome',
            'email' => 'duplicado@example.com',
            'password' => 'senha1234',
            'role' => 'admin',
        ];

        $response = $this->postJson('/api/users', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email'])
        ;
    }
}
