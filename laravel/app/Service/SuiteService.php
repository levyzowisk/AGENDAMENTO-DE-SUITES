<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\Suite\SuiteRepositoryInterface;
use App\Contracts\Suite\SuiteServiceInterface;
use App\Models\Suite;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SuiteService implements SuiteServiceInterface
{
    public function __construct(
        private readonly SuiteRepositoryInterface $suiteRepository,
    ) {}

    public function getAllSuites(): Collection
    {
        return $this->suiteRepository->all();
    }

    public function show(int $id): ?Suite
    {
        $suite = $this->suiteRepository->show($id);

        if (!$suite) {
            throw new NotFoundHttpException();
        }

        return $suite;
    }

    public function store(array $data): Suite
    {
        return $this->suiteRepository->store($data);
    }

    public function update(int $id, array $data): Suite
    {
        $suite = $this->show($id);

        return $this->suiteRepository->update($suite, $data);
    }

    public function destroy(int $id): void
    {
        $this->show($id);

        $this->suiteRepository->destroy($id);
    }
}
