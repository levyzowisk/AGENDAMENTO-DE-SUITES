<?php

declare(strict_types=1);

namespace Tests\Feature\Schedule;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsEmptyListWhenNoSchedules(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->getJson('/api/schedules');

        $response->assertStatus(200)
            ->assertJson([])
        ;
    }

    public function testReturnsListOfSchedulesWithExpectedFields(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        Schedule::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/schedules');

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'user_id',
                    'suite_id',
                    'suite_unit_id',
                    'check_in',
                    'check_out',
                    'status',
                    'total_price',
                    'notes',
                    'created_at',
                    'updated_at',
                    'user',
                    'suite',
                    'suite_unit',
                ],
            ])
        ;
    }

    public function testRequiresAuthentication(): void
    {
        $response = $this->getJson('/api/schedules');
        $response->assertStatus(401);
    }
}
