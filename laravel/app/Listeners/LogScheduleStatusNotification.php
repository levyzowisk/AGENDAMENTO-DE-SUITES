<?php

namespace App\Listeners;

use App\Events\ScheduleStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogScheduleStatusNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ScheduleStatusChanged $event): void
    {
        $schedule = $event->schedule;
        $user = $schedule->user;

        \Illuminate\Support\Facades\Log::info("Notificação de Agendamento: O usuário {$user->name} ({$user->email}) foi notificado que o agendamento #{$schedule->id} mudou para o status: {$schedule->status->value}.");
    }
}
