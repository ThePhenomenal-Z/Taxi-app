<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
       /**
     * Determine whether the user can view the model.
     */
    public function viewAny(User $user)
    {
        if ($user->driver)
            return false;
        return true;
    }
        /**
     * Determine whether the user can update the model.
     */
    public function updateUser(User $user): bool
    {
        
        if ($user->driver)
            return false;
        return true;
    }
}
