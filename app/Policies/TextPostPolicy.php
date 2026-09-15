<?php

namespace App\Policies;

use App\Models\TextPost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TextPostPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function modify(User $user, TextPost $textPost): Response
    {
        return $user->is($textPost->user) ? Response::allow() : Response::denyAsNotFound();
    }

}
