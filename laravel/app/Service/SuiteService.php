<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\Suite\SuiteServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Suite\SuiteRepositoryInterface;

class SuiteService implements SuiteServiceInterface
{
    public function __construct(
        private readonly SuiteRepositoryInterface $suiteRepository
    )
    {
    }

    public function getAllSuites(): Collection
    {
        return $this->suiteRepository->all();
    }
}