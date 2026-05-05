<?php

declare(strict_types=1);

namespace App\Enums;

enum ScheduleStatusEnum: string
{
    case PENDING = 'PENDING';
    case CONFIRMED = 'CONFIRMED';
    case CANCELLED = 'CANCELLED';
    case COMPLETED = 'COMPLETED';
    case NO_SHOW = 'NO_SHOW';
}
