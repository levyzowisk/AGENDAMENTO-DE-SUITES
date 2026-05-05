<?php

declare(strict_types=1);

namespace Tests\Feature\Schedule;

use App\Enums\ScheduleStatusEnum;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUpdateASchedule(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $schedule = Schedule::factory()->create(['user_id' => $user->id, 'status' => ScheduleStatusEnum::PENDING->value]);

        $payload = [
            'status' => ScheduleStatusEnum::CONFIRMED->value,
            'notes' => 'Updated note',
        ];

        $response = $this->actingAs($user)->patchJson('/api/schedules/' . $schedule->id, $payload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => ScheduleStatusEnum::CONFIRMED->value,
                'notes' => 'Updated note',
            ]);

        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'status' => ScheduleStatusEnum::CONFIRMED->value,
            'notes' => 'Updated note',
        ]);
    }

    public function testReturns404IfNotFound(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->patchJson('/api/schedules/9999', ['notes' => 'test']);

        $response->assertStatus(404);
    }

    public function testRequiresAuthentication(): void
    {
        $response = $this->patchJson('/api/schedules/1', []);
        $response->assertStatus(401);
    }
}
