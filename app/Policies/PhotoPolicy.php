<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;

class PhotoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Photo $photo)
    {
        return $user->id === $photo->user_id;
    }

    public function delete(User $user, Photo $photo)
    {
        return $user->id === $photo->user_id;
    }
}
