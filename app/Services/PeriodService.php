<?php

namespace App\Services;

use App\Models\Period;
use App\Models\User;
use App\Helpers\TimeCalculator;
use Illuminate\Database\Eloquent\Collection;

class PeriodService
{
    public function getAll(): Collection
    {
        return Period::with('user:id,name')->latest()->get();
    }

    public function store(User $user, array $data)
    {
        $period = new Period($data);
        $period['user_id'] = $user->id;

        $times = TimeCalculator::calculateDayAndNightTime($period->time_start, $period->time_end);
        $period->day_time = $times['day_time'];
        $period->night_time = $times['night_time'];

        $period->save();
    }

    public function update(Period $period, array $data)
    {
        $calculatedTimes = TimeCalculator::calculateDayAndNightTime($data['time_start'], $data['time_end']);
        $data['day_time'] = $calculatedTimes['day_time'];
        $data['night_time'] = $calculatedTimes['night_time'];

        $period->update($data);
    }
}