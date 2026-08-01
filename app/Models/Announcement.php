<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [

        'title',

        'content',

        'created_by',

        'is_published',

        'is_pinned',

        'published_at',

        'expires_at',

    ];

    protected $casts = [

        'is_published' => 'boolean',

        'is_pinned' => 'boolean',

        'published_at' => 'datetime',

        'expires_at' => 'datetime',

    ];

    /**
     * Administrator who posted the announcement.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}