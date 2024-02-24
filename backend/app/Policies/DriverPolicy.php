<?php

namespace App\Policies;

use App\Models\User;

class DriverPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function viewAny(User $user)
    {
        if ($user->driver)
            return true;
        return false;
    }
        /**
     * Determine whether the user can update the model.
     */
    public function updateDriver(User $user): bool
    {
        if ($user->driver)
            return true;
        return false;
    }

}
