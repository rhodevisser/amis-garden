<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Photo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'src', 'alt', 'description', 'user_id'];

    protected $casts = [
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function snacks(): HasMany
    {
        return $this->hasMany(PhotoSnack::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the URL for the photo source.
     *
     * Returns the raw URL for external images, or the storage URL for local files.
     */
    public function getSrcUrlAttribute(): string
    {
        if (Str::startsWith($this->src, ['http://', 'https://'])) {
            return $this->src;
        }

        return Storage::url($this->src);
    }
}
