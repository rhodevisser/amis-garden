<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Key extends Model
{
    // These fields can be mass-assigned (filled all at once)
    // This protects against accidentally setting fields like 'id'
    protected $fillable = [
        'key',           // The actual key string
        'used_at',       // When it was used
        'used_by',       // User ID who used it
        'expires_at',    // When it expires
    ];

    // Tell Laravel which fields should be treated as dates
    // This automatically converts them to Carbon instances for easy date manipulation
    // Example: $key->used_at->format('Y-m-d') or $key->expires_at->isPast()
    protected $casts = [
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Check if this key has already been used
     *
     * @return bool True if key is used, false if still available
     */
    public function isUsed(): bool
    {
        // If used_at is not null, the key has been used
        return !is_null($this->used_at);
    }

    /**
     * Check if this key has expired
     *
     * @return bool True if expired, false if still valid
     */
    public function isExpired(): bool
    {
        // If expires_at is null, key never expires (return false)
        // If expires_at is set, check if it's in the past
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if this key is valid (not used and not expired)
     *
     * @return bool True if key can be used, false otherwise
     */
    public function isValid(): bool
    {
        // Key is valid if it's not used AND not expired
        return !$this->isUsed() && !$this->isExpired();
    }

    /**
     * Relationship: Get the user who used this key
     *
     * BelongsTo means "this key belongs to one user"
     * Returns null if key hasn't been used yet
     *
     * Usage: $key->user->name (gets name of user who used this key)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'used_by');
    }
}
