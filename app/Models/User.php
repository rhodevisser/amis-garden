<?php

namespace App\Models;

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

    public function registrationKey(): HasOne
    {
        return $this->hasOne(Key::class, 'used_by');
    }

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }

    /**
     * Get pets where this user is the primary owner.
     */
    public function ownedPets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }

    /**
     * Get pets where this user is a co-owner.
     *
     * @return BelongsToMany<Pet, static>
     */
    public function coOwnedPets(): BelongsToMany
    {
        return $this->belongsToMany(Pet::class, 'pet_user');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function photoSnacks(): HasMany
    {
        return $this->hasMany(PhotoSnack::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function commentLikes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }
}
