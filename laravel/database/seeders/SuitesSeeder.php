<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Suite;
use App\Models\SuiteUnit;
use App\Enums\SuiteStatusEnum;

class SuitesSeeder extends Seeder
{
    public function run(): void
    {
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

        foreach ($suites as $suiteData) {
            $suite = Suite::updateOrCreate(
                ['type_suite' => $suiteData['type_suite']],
                ['amount_per_hour' => $suiteData['amount_per_hour']]
            );

            // Se for criar as unidades, garante que n duplique cada vez q rodar a seed
            if ($suite->units()->count() === 0) {
                $unitsToCreate = [];
                for ($i = 0; $i < $suiteData['available_count']; $i++) {
                    $unitsToCreate[] = [
                        'suite_id' => $suite->id,
                        'room_number' => "SU-" . $suite->id . "0" . ($i + 1),
                        'status' => SuiteStatusEnum::FREE->value,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                SuiteUnit::insert($unitsToCreate);
            }
        }
    }
}
