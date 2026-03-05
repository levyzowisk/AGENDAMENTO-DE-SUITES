<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuitesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = now();

        $suites = [
            [
                'type_suite' => 'SIMPLES',
                'amount_per_hour' => 79.90,
                'available_count' => 8,
            ],
            [
                'type_suite' => 'PLUS',
                'amount_per_hour' => 119.90,
                'available_count' => 5,
            ],
            [
                'type_suite' => 'PRIME',
                'amount_per_hour' => 169.90,
                'available_count' => 3,
            ],
        ];

        foreach ($suites as $suite) {
            DB::table('suites')->updateOrInsert(
                ['type_suite' => $suite['type_suite']],
                [
                    'amount_per_hour' => $suite['amount_per_hour'],
                    'available_count' => $suite['available_count'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}
