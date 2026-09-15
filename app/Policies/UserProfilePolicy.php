<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Access\Response;

class UserProfilePolicy
{
    /**
     * Determine whether the user can modify the model.
     */
    public function modify(User $user, UserProfile $userProfile): Response
    {
        return $user->is($userProfile->user) ? Response::allow() : Response::denyAsNotFound();
    }
}
