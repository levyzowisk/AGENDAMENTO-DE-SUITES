<?php

namespace App\Http\Controllers;

use App\Contracts\Suite\SuiteServiceInterface;
use App\Http\Resources\SuiteResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SuiteController extends Controller
{
    public function __construct(
        private readonly SuiteServiceInterface $suiteServiceInterface
    )
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $suites = $this->suiteServiceInterface->getAllSuites();
        return SuiteResource::collection($suites);
    }

    public function suiteMap()
    {
        return [
            [
                "id" => 1,
                "type" => "simples",
                "status" => "FREE",
                "lastCleaning" => "2024-06-01T10:00:00Z",
            ],
            [
                "id" => 2,
                "type" => "simples",
                "status" => "OCCUPIED",
                "checkInTime" => "1740482400000",
                
            ],
            [
                "id" => 3,
                "type" => "BOOKED",
                "booking" => [
                    "customerName" => "Jonh Doe", 
                    "scheduledTime" => "2024-06-01T15:00:00Z",
                ]
            ]
        ];
    }
}
