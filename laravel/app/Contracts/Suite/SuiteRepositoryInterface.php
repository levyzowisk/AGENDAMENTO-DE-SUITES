<?php

declare(strict_types=1);

namespace App\Contracts\Suite;

use App\Models\Suite;
use Illuminate\Database\Eloquent\Collection;

interface SuiteRepositoryInterface
{
    public function all(): Collection;

    public function show(int $id): ?Suite;

    public function store(array $data): Suite;

    public function destroy(int $id): void;

    public function update(Suite $suite, array $data): Suite;
}
