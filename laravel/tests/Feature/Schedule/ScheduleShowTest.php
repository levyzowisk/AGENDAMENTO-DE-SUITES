<?php

declare(strict_types=1);

namespace Tests\Feature\Schedule;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleShowTest extends TestCase
{
    use RefreshDatabase;

    public function testCanShowASchedule(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $schedule = Schedule::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/schedules/' . $schedule->id);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $schedule->id,
                'user_id' => $user->id,
            ]);
    }

    public function testReturns404IfNotFound(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->getJson('/api/schedules/9999');

        $response->assertStatus(404);
    }

    public function testRequiresAuthentication(): void
    {
        $response = $this->getJson('/api/schedules/1');
        $response->assertStatus(401);
    }
}
