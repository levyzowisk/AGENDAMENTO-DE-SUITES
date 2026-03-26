<?php

namespace App\Enums;

enum SuiteStatusEnum: string
{
    case FREE = 'FREE';
    case OCCUPIED = 'OCCUPIED';
    case CLEANING = 'CLEANING';
    case MAINTENANCE = 'MAINTENANCE';
    case BOOKED = 'BOOKED';
}
