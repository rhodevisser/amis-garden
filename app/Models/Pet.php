<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        return $this->belongsTo(User::class, 'user_id');
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

    /**
     * Get the URL for the pet image.
     *
     * Returns the raw URL for external images, or the storage URL for local files.
     */
    public function getImageUrlAttribute(): string
    {
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return Storage::url($this->image);
    }
}
