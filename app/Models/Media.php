<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Media extends Model
{
    public function userMedia(): MorphToMany{
        return $this->morphedByMany(UserProfile::class, 'mediaable');
    }

    public function postMedia(): MorphToMany{
        return $this->morphedByMany(ImagePost::class, 'mediaable');
    }

}
