<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\Schedule\ScheduleRepositoryInterface;
use App\Contracts\Schedule\ScheduleServiceInterface;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ScheduleService implements ScheduleServiceInterface
{
    public function __construct(
        protected ScheduleRepositoryInterface $repository
    ) {}

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function show(int $id): ?Schedule
    {
        $schedule = $this->repository->show($id);

        if (! $schedule) {
            throw new NotFoundHttpException('Schedule not found');
        }

        return $schedule;
    }

    public function store(array $data): Schedule
    {
        return $this->repository->store($data);
    }

    public function update(Schedule $schedule, array $data): Schedule
    {
        $oldStatus = $schedule->status;
        $updatedSchedule = $this->repository->update($schedule, $data);

        // Se houve mudança de status e temos uma unidade vinculada, atualiza o status do quarto
        if (isset($data['status']) && $oldStatus->value !== $data['status']) {
            if ($updatedSchedule->suite_unit_id) {
                $unit = $updatedSchedule->suiteUnit;

                switch ($data['status']) {
                    case \App\Enums\ScheduleStatusEnum::CONFIRMED->value:
                        $unit->update(['status' => \App\Enums\SuiteStatusEnum::BOOKED->value]);
                        break;
                    case \App\Enums\ScheduleStatusEnum::COMPLETED->value:
                        $unit->update(['status' => \App\Enums\SuiteStatusEnum::CLEANING->value]);
                        break;
                    case \App\Enums\ScheduleStatusEnum::CANCELLED->value:
                        $unit->update(['status' => \App\Enums\SuiteStatusEnum::FREE->value]);
                        break;
                }
            }

            // Dispara evento para notificar o usuário (por enquanto em log)
            \App\Events\ScheduleStatusChanged::dispatch($updatedSchedule);
        }

        return $updatedSchedule;
    }

    public function destroy(int $id): void
    {
        $schedule = $this->repository->show($id);

        if (! $schedule) {
            throw new NotFoundHttpException('Schedule not found');
        }

        $this->repository->destroy($id);
    }
}
