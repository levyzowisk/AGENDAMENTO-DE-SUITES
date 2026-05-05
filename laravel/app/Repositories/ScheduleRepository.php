<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Schedule\ScheduleRepositoryInterface;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    public function all(): Collection
    {
        return Schedule::with(['user', 'suite', 'suiteUnit'])->get();
    }

    public function show(int $id): ?Schedule
    {
        return Schedule::with(['user', 'suite', 'suiteUnit'])->find($id);
    }

    public function store(array $data): Schedule
    {
        return Schedule::create($data);
    }

    public function update(Schedule $schedule, array $data): Schedule
    {
        $schedule->update($data);

        return $schedule;
    }

    public function destroy(int $id): void
    {
        Schedule::destroy($id);
    }
}
