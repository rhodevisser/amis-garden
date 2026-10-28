<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'species', 'breed', 'age', 'gender', 'description', 'image', 'user_id'];

    protected $casts = [
        'age' => 'integer',
        'gender' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the co-owners of the pet.
     *
     * @return BelongsToMany<User, static>
     */
    public function coOwners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pet_user');
    }
}
