<?php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'suite_id' => \App\Models\Suite::factory(),
            'suite_unit_id' => \App\Models\SuiteUnit::factory(),
            'check_in' => now()->addDays(1),
            'check_out' => now()->addDays(2),
            'status' => \App\Enums\ScheduleStatusEnum::PENDING->value,
            'total_price' => $this->faker->randomFloat(2, 50, 500),
            'notes' => $this->faker->sentence(),
        ];
    }
}
