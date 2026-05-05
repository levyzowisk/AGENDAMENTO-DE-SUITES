<?php

namespace Database\Factories;

use App\Models\SuiteUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SuiteUnit>
 */
class SuiteUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'suite_id' => \App\Models\Suite::factory(),
            'room_number' => $this->faker->unique()->numberBetween(100, 999),
            'status' => \App\Enums\SuiteStatusEnum::FREE->value,
        ];
    }
}
