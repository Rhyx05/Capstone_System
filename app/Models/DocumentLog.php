<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentLog extends Model
{
    use HasFactory;

    protected $fillable = [

        'document_id',

        'user_id',

        'action',

        'remarks',

    ];

    /*
    |--------------------------------------------------------------------------
    | Document
    |--------------------------------------------------------------------------
    */

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /*
    |--------------------------------------------------------------------------
    | User who performed the action
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}