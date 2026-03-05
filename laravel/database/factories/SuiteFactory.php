<?php

namespace Database\Factories;

use App\Models\Suite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suite>
 */
class SuiteFactory extends Factory
{
    protected $model = Suite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['SIMPLES', 'PLUS', 'PRIME'];

        return [
            'type_suite' => fake()->randomElement($types),
            'amount_per_hour' => fake()->randomFloat(2, 69.90, 249.90),
            'available_count' => fake()->numberBetween(1, 12),
        ];
    }
}
