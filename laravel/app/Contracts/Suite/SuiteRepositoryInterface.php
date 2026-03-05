<?php

declare(strict_types=1);

namespace App\Contracts\Suite;

use App\Models\Suite;
use Illuminate\Database\Eloquent\Collection;

interface SuiteRepositoryInterface{
    public function all(): Collection;
}