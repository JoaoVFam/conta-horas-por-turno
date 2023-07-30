<?php

namespace App\Services;

use App\Models\Period;
use Illuminate\Database\Eloquent\Collection;

class PeriodService
{
    public function getAll(): Collection
    {
        return Period::with('user:id,name')->latest()->get();
    }
}