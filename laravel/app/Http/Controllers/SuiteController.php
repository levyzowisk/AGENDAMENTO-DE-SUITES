<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Suite\SuiteServiceInterface;
use App\Http\Requests\Suite\StoreSuiteRequest;
use App\Http\Requests\Suite\UpdateSuiteRequest;
use App\Http\Resources\SuiteResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SuiteController extends Controller
{
    public function __construct(
        private readonly SuiteServiceInterface $suiteServiceInterface,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $suites = $this->suiteServiceInterface->getAllSuites();

        return SuiteResource::collection($suites);
    }

    public function show(int $id): SuiteResource
    {
        $suite = $this->suiteServiceInterface->show($id);

        return new SuiteResource($suite);
    }

    public function store(StoreSuiteRequest $request): JsonResponse
    {
        $suite = $this->suiteServiceInterface->store($request->validated());

        return response()->json(new SuiteResource($suite), 201);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->suiteServiceInterface->destroy($id);

        return response()->json(null, 204);
    }

    public function update(UpdateSuiteRequest $request, int $id): JsonResponse
    {
        $updatedSuite = $this->suiteServiceInterface->update($id, $request->validated());

        return response()->json(new SuiteResource($updatedSuite));
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
