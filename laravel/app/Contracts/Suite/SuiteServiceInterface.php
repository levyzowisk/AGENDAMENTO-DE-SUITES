<?php

namespace App\Contracts\Suite;

use Illuminate\Database\Eloquent\Collection;
use \App\Models\Suite;
interface SuiteServiceInterface
{
    public function getAllSuites(): Collection;

    public function show (int $id): ?Suite;

    public function store(array $data): Suite;

    public function destroy(int $id): void;

    public function update(int $id, array $data): Suite;

    
}