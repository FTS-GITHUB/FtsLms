<?php

namespace App\Observers\Permissions;

use App\Models\User;

class UserObserver
{
    public function updating(User $user)
    {
        // resetting verification on email update
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        };
    }
}
