<?php

namespace App\Repositories;

use App\Contracts\Suite\SuiteRepositoryInterface;
use App\Models\Suite;
use Illuminate\Database\Eloquent\Collection;

class SuiteRepository implements SuiteRepositoryInterface
{
    public function all(): Collection
    {
        return Suite::all();
    }


}