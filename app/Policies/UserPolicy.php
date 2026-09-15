<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function modify(User $user, User $model): Response
    {
        return $user->is($model) ? Response::allow() : Response::denyAsNotFound();
    }
}
