<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Photo extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['title', 'src', 'alt', 'description', 'user_id'];

    protected $casts = [
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeNewest()
    {
        return $this->orderBy('created_at', 'desc');
    }

    public function scopeOldest()
    {
        return $this->orderBy('created_at', 'asc');
    }


}
