<?php

namespace App\Policies;

use App\Models\Period;
use App\Models\User;

class PeriodPolicy
{
    public function update(User $user, Period $period): bool
    {
        return $period->user()->is($user);
    }

    public function delete(User $user, Period $period): bool
    {
        return $this->update($user, $period);
    }
}
