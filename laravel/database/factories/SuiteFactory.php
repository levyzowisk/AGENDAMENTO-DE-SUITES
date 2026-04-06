<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SuiteStatusEnum;
use App\Models\Suite;
use App\Models\SuiteUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suite>
 */
class SuiteFactory extends Factory
{
    protected $model = Suite::class;

    public function definition(): array
    {
        $types = ['SIMPLES', 'PLUS', 'PRIME'];

        return [
            'type_suite' => fake()->randomElement($types),
            'amount_per_hour' => fake()->randomFloat(2, 69.90, 249.90),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Suite $suite) {
            $count = fake()->numberBetween(1, 5);
            for ($i = 0; $i < $count; ++$i) {
                SuiteUnit::create([
                    'suite_id' => $suite->id,
                    'room_number' => 'SU-' . $suite->id . '0' . ($i + 1),
                    'status' => SuiteStatusEnum::FREE->value,
                ]);
            }
        });
    }
}
