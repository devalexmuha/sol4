<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    public function textPosts(): MorphToMany
    {
        return $this->morphedByMany(
            TextPost::class,
            'taggable'
        );
    }

    public function imagePosts(): MorphToMany
    {
        return $this->morphedByMany(
            ImagePost::class,
            'taggable'
        );
    }
}
