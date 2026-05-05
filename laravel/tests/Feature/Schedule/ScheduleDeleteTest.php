<?php

declare(strict_types=1);

namespace Tests\Feature\Schedule;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function testCanDeleteASchedule(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $schedule = Schedule::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson('/api/schedules/' . $schedule->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('schedules', [
            'id' => $schedule->id,
        ]);
    }

    public function testReturns404IfNotFound(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->deleteJson('/api/schedules/9999');

        $response->assertStatus(404);
    }

    public function testRequiresAuthentication(): void
    {
        $response = $this->deleteJson('/api/schedules/1');
        $response->assertStatus(401);
    }
}
