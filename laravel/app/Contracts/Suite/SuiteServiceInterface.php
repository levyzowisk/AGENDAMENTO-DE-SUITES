<?php

namespace App\Contracts\Suite;

use Illuminate\Database\Eloquent\Collection;

interface SuiteServiceInterface
{
    public function getAllSuites(): Collection;
}