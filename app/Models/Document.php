<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\DocumentLog;
use App\Models\ElectronicFilingCategory;
use App\Models\User;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [

        'tracking_code',

        'title',

        'category',

        'priority',

        'description',

        'extracted_text',

        'file_name',

        'file_path',

        'file_type',

        'file_size',

        'submitted_by',

        'office_id',

        'receiver_office_id',

        /*
        |--------------------------------------------------------------------------
        | Electronic Filing
        |--------------------------------------------------------------------------
        */

        'filing_category_id',

        'archived_at',

        /*
        |--------------------------------------------------------------------------
        | Workflow
        |--------------------------------------------------------------------------
        */

        'assigned_to',

        'sent_to',

        'assigned_at',

        'approved_by',

        'approved_at',

        'reviewed_by',

        'reviewed_at',

        'remarks',

        'status',

        'submission_date',

        /*
        |--------------------------------------------------------------------------
        | Processing Workflow
        |--------------------------------------------------------------------------
        */

        'processing_started_at',

        'processing_completed_at',

        'forwarded_at',

        'current_step',

        'workflow_status',
    ];

    protected $casts = [

        'submission_date' => 'datetime',

        'assigned_at' => 'datetime',

        'approved_at' => 'datetime',

        'reviewed_at' => 'datetime',

        'processing_started_at' => 'datetime',

        'processing_completed_at' => 'datetime',

        'forwarded_at' => 'datetime',

        'archived_at' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | Employee who submitted the document
    |--------------------------------------------------------------------------
    */

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Employee the document was directly sent to
    |--------------------------------------------------------------------------
    */

    public function sentTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_to');
    }

    /*
    |--------------------------------------------------------------------------
    | Origin Office
    |--------------------------------------------------------------------------
    */

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Receiving Office
    |--------------------------------------------------------------------------
    */

    public function receiverOffice(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'receiver_office_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Assigned Employee
    |--------------------------------------------------------------------------
    */

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /*
    |--------------------------------------------------------------------------
    | Administrator who approved routing
    |--------------------------------------------------------------------------
    */

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Administrator reviewer
    |--------------------------------------------------------------------------
    */

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Electronic Filing Repository
    |--------------------------------------------------------------------------
    */

    public function filingCategory(): BelongsTo
    {
        return $this->belongsTo(
            ElectronicFilingCategory::class,
            'filing_category_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Audit Trail
    |--------------------------------------------------------------------------
    */

    public function logs(): HasMany
    {
        return $this->hasMany(DocumentLog::class)
                    ->latest();
    }

    /*
|--------------------------------------------------------------------------
| Submitter
|--------------------------------------------------------------------------
*/

public function submitter(): BelongsTo
{
    return $this->belongsTo(User::class, 'submitted_by');
}



    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isAssigned(): bool
    {
        return $this->workflow_status === 'assigned';
    }

    public function isProcessing(): bool
    {
        return $this->workflow_status === 'processing';
    }

    public function isCompleted(): bool
    {
        return $this->workflow_status === 'completed';
    }

    public function isForwarded(): bool
    {
        return $this->workflow_status === 'forwarded';
    }

    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }
}