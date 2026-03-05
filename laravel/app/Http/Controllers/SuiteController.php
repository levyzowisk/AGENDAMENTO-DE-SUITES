<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class SuiteController extends Controller
{
    public function index(): array
    {
        return [
            [
                'id' => 1,
                'type' => 'suite',
                'amountPerHour' => 100,
                'availableCount' => 5,
                'features' => [
                    'TV',
                    'Ar-condicionado',
                ],
            ],
            [
                'id' => 2,
                'type' => 'suite',
                'amountPerHour' => 150,
                'availableCount' => 3,
                'features' => [
                    'TV',
                    'Ar-condicionado',
                    'Frigobar',
                ],
            ],
        ];
    }

    public function suiteMap()
    {
        return [
            [
                'id' => 1,
                'type' => 'simples',
                'status' => 'FREE',
                'lastCleaning' => '2024-06-01T10:00:00Z',
            ],
            [
                'id' => 2,
                'type' => 'simples',
                'status' => 'OCCUPIED',
                'checkInTime' => '1740482400000',
            ],
            [
                'id' => 3,
                'type' => 'BOOKED',
                'booking' => [
                    'customerName' => 'Jonh Doe',
                    'scheduledTime' => '2024-06-01T15:00:00Z',
                ],
            ],
        ];
    }
}
