<?php

namespace App\Policies;

use App\Models\ImagePost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ImagePostPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function modify(User $user, ImagePost $imagePost): Response
    {
        return $user->is($imagePost->user) ? Response::allow() : Response::denyAsNotFound();
    }

}
