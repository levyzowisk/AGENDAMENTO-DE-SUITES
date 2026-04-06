<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Suite\SuiteRepositoryInterface;
use App\Enums\SuiteStatusEnum;
use App\Models\Suite;
use App\Models\SuiteUnit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SuiteRepository implements SuiteRepositoryInterface
{
    public function all(): Collection
    {
        return Suite::all();
    }

    public function show(int $id): ?Suite
    {
        return Suite::find($id);
    }

    public function store(array $data): Suite
    {
        return DB::transaction(function () use ($data) {
            // 1. Cria a Categoria (Type_Suite)
            $suite = Suite::create([
                'type_suite' => $data['type_suite'],
                'amount_per_hour' => $data['amount_per_hour'],
            ]);

            $countToCreate = (int) ($data['available_count'] ?? 1);

            // 2. Prepara os registros de quartos físicos reais (Inventário)
            $unitsToCreate = [];
            for ($i = 0; $i < $countToCreate; ++$i) {
                $unitsToCreate[] = [
                    'suite_id' => $suite->id,
                    'room_number' => 'SU-' . $suite->id . '0' . ($i + 1), // Ex: SU-101, SU-102
                    'status' => SuiteStatusEnum::FREE->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // 3. Cadastra fisicamente as suítes
            if (!empty($unitsToCreate)) {
                SuiteUnit::insert($unitsToCreate);
            }

            return $suite;
        });
    }

    public function destroy(int $id): void
    {
        Suite::destroy($id);
    }

    public function update(Suite $suite, array $data): Suite
    {
        $suite->update($data);

        return $suite;
    }
}
