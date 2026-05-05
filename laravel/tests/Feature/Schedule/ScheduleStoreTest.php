<?php

declare(strict_types=1);

namespace Tests\Feature\Schedule;

use App\Enums\ScheduleStatusEnum;
use App\Models\Suite;
use App\Models\SuiteUnit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testCanStoreASchedule(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $suite = Suite::factory()->create();
        $suiteUnit = SuiteUnit::factory()->create(['suite_id' => $suite->id]);

        $payload = [
            'user_id' => $user->id,
            'suite_id' => $suite->id,
            'suite_unit_id' => $suiteUnit->id,
            'check_in' => now()->addDays(1)->toDateTimeString(),
            'check_out' => now()->addDays(2)->toDateTimeString(),
            'status' => ScheduleStatusEnum::PENDING->value,
            'total_price' => 150.50,
            'notes' => 'Testing schedule creation',
        ];

        $response = $this->actingAs($user)->postJson('/api/schedules', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'user_id' => $user->id,
                'suite_id' => $suite->id,
                'suite_unit_id' => $suiteUnit->id,
                'status' => ScheduleStatusEnum::PENDING->value,
                'notes' => 'Testing schedule creation',
            ]);

        $this->assertDatabaseHas('schedules', [
            'user_id' => $user->id,
            'suite_id' => $suite->id,
            'status' => ScheduleStatusEnum::PENDING->value,
        ]);
    }

    public function testFailsWhenValidationFails(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->postJson('/api/schedules', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_id', 'suite_id', 'check_in', 'check_out']);
    }

    public function testRequiresAuthentication(): void
    {
        $response = $this->postJson('/api/schedules', []);
        $response->assertStatus(401);
    }
}
