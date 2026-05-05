<?php

declare(strict_types=1);

namespace App\Contracts\Schedule;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleServiceInterface
{
    public function all(): Collection;

    public function show(int $id): ?Schedule;

    public function store(array $data): Schedule;

    public function update(Schedule $schedule, array $data): Schedule;

    public function destroy(int $id): void;
}
