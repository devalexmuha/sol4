<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userProfile(): HasOne
    {
      return $this->hasOne(UserProfile::class);
    }

    public function subscribers(): BelongsToMany{
        return $this->belongsToMany(User::class, 'subscriptions', 'subscribed_to' , 'subscriber' ); // filter by / zip by
    }

    public function subscribedTo(): BelongsToMany{
        return $this->belongsToMany(User::class, 'subscriptions', 'subscriber', 'subscribed_to' ); // filter by / zip by
    }

    public function textPosts(): HasMany{
        return $this->hasMany(TextPost::class);
    }

    public function imagePosts(): HasMany{
        return $this->hasMany(imagePost::class);
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany{
        return $this->hasMany(Like::class);
    }
}
