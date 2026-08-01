<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditLogger;

class IncomingDocumentsController extends Controller
{
    /**
     * Incoming documents list.
     */
/**
 * Incoming documents list.
 */
public function index(Request $request)
{
    $query = Document::where(function ($q) {
        $q->where('assigned_to', Auth::id())
          ->orWhere('sent_to', Auth::id());
    })

    // Hide documents that are already finished
    ->whereNotIn('status', [
        'completed',
        'rejected',
        'forwarded',
        'archived',
    ])

    // Sort by priority first
    ->orderByRaw("
        CASE priority
            WHEN 'Urgent' THEN 1
            WHEN 'High' THEN 2
            WHEN 'Normal' THEN 3
            ELSE 4
        END
    ")

    // Then newest assignment
    ->orderByDesc('assigned_at');

    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('tracking_code', 'like', "%{$request->search}%")
                ->orWhere('title', 'like', "%{$request->search}%");

        });

    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    $documents = $query
        ->with([
            'submittedBy',
            'office',
            'receiverOffice',
            'assignedUser',
            'sentTo',
            'approver',
            'reviewer',
            'logs.user',
        ])
        ->paginate(10)
        ->withQueryString();

    return view('user.incoming', [

        'documents' => $documents,

        'incomingCount' => Document::where(function ($q) {
                $q->where('assigned_to', Auth::id())
                  ->orWhere('sent_to', Auth::id());
            })->count(),

        'assignedCount' => Document::where(function ($q) {
                $q->where('assigned_to', Auth::id())
                  ->orWhere('sent_to', Auth::id());
            })
            ->where('status', 'assigned')
            ->count(),

        'completedCount' => Document::where(function ($q) {
                $q->where('assigned_to', Auth::id())
                  ->orWhere('sent_to', Auth::id());
            })
            ->where('status', 'completed')
            ->count(),

        'archivedCount' => Document::where(function ($q) {
                $q->where('assigned_to', Auth::id())
                  ->orWhere('sent_to', Auth::id());
            })
            ->where('status', 'archived')
            ->count(),

    ]);
}

/**
 * View document.
 */
public function show(Document $document)
{
abort_unless(
    $document->assigned_to == Auth::id() ||
    $document->sent_to == Auth::id(),
    403
);

    $document->load([
        'submittedBy',
        'office',
        'receiverOffice',
        'assignedUser',
        'sentTo',
        'approver',
        'reviewer',
        'logs.user',
    ]);

    $offices = Office::orderBy('office_name')->get();

    $users = User::with('office')
        ->where('role', 'user')
        ->where('is_active', true)
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get();

    return view(
        'user.incoming-show',
        compact(
            'document',
            'offices',
            'users'
        )
    );
}

    /**
     * Employee starts processing.
     */
    public function receive(Document $document)
    {
abort_unless(
    $document->assigned_to == Auth::id() ||
    $document->sent_to == Auth::id(),
    403
);

        if ($document->status !== 'assigned') {

            return back()->with(
                'error',
                'Only assigned documents can be processed.'
            );

        }

        $document->update([

            'status' => 'processing',

            'started_processing_at' => now(),

        ]);

        DocumentLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id(),

            'action' => 'Started Processing',

            'remarks' => 'Employee started processing.',

        ]);

AuditLogger::log(
    'Incoming Documents',
    'Started Processing',
    Auth::user()->full_name .
    ' started processing "' .
    $document->title .
    '".'
);
        return back()->with(
            'success',
            'Processing started.'
        );
    }

    /**
     * Employee submits for approval.
     */
    public function submit(Request $request, Document $document)
    {
abort_unless(
    $document->assigned_to == Auth::id() ||
    $document->sent_to == Auth::id(),
    403
);

        $request->validate([

            'remarks' => 'nullable|string|max:1000',

        ]);

        $document->update([

            'status' => 'pending_approval',

            'remarks' => $request->remarks,

            'submitted_for_approval_at' => now(),

        ]);

        DocumentLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id(),

            'action' => 'Submitted for Approval',

            'remarks' => $request->remarks
                ?: 'Employee submitted the document for approval.',

        ]);

AuditLogger::log(
    'Incoming Documents',
    'Submitted',
    Auth::user()->full_name .
    ' submitted processed document "' .
    $document->title .
    '".'
);

        return back()->with(
            'success',
            'Document submitted for approval.'
        );
    }

    /**
     * Forward document.
     */
    public function forward(Request $request, Document $document)
    {
abort_unless(
    $document->assigned_to == Auth::id() ||
    $document->sent_to == Auth::id(),
    403
);

        $request->validate([

    'receiver_office_id' => [
        'required',
        'exists:offices,id',
    ],

    'assigned_to' => [
        'required',
        'exists:users,id',
    ],

    'remarks' => [
        'nullable',
        'string',
        'max:1000',
    ],

]);

$employee = User::findOrFail($request->assigned_to);

$office = Office::findOrFail($request->receiver_office_id);

/*
|--------------------------------------------------------------------------
| Security Validation
|--------------------------------------------------------------------------
|
| Prevent assigning an employee who does not belong to the selected office.
|
*/

if ($employee->office_id != $office->id) {

    return back()
        ->withErrors([
            'assigned_to' => 'The selected employee does not belong to the selected office.',
        ])
        ->withInput();

}

        $document->update([

            'status' => 'assigned',

            'receiver_office_id' => $office->id,

            'assigned_to' => $employee->id,

            'assigned_at' => now(),

            'remarks' => $request->remarks,

            'started_processing_at' => null,

            'submitted_for_approval_at' => null,

        ]);

        DocumentLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id(),

            'action' => 'Forwarded',

            'remarks' =>
                'Forwarded to '
                . $employee->full_name
                . ' ('
                . $office->office_name
                . ')',

        ]);

AuditLogger::log(
    'Incoming Documents',
    'Forwarded',
    Auth::user()->full_name .
    ' forwarded "' .
    $document->title .
    '" to ' .
    $employee->full_name .
    ' (' .
    $office->office_name .
    ').'
);
     return redirect()
    ->route('user.incoming')
    ->with(
        'success',
        'Document forwarded successfully.'
    );
    }

    /**
 * Reject document.
 */
public function reject(Request $request, Document $document)
{
    abort_unless(
        $document->assigned_to == Auth::id() ||
        $document->sent_to == Auth::id(),
        403
    );

    $request->validate([
        'remarks' => 'nullable|string|max:1000',
    ]);

    $document->update([
        'status' => 'rejected',
        'remarks' => $request->remarks,
    ]);

    DocumentLog::create([
        'document_id' => $document->id,
        'user_id' => Auth::id(),
        'action' => 'Rejected',
        'remarks' => $request->remarks ?: 'Document rejected.',
    ]);

    AuditLogger::log(
        'Incoming Documents',
        'Rejected',
        Auth::user()->full_name .
        ' rejected "' .
        $document->title .
        '".'
    );

    return redirect()
        ->route('user.incoming')
        ->with('success', 'Document rejected successfully.');
}

    /**
     * Complete processing.
     */
    public function complete(Request $request, Document $document)
    {
abort_unless(
    $document->assigned_to == Auth::id() ||
    $document->sent_to == Auth::id(),
    403
);

        $request->validate([

            'remarks' => 'nullable|string|max:1000',

        ]);

        $document->update([

            'status' => 'completed',

            'remarks' => $request->remarks,

        ]);

        DocumentLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id(),

            'action' => 'Completed',

            'remarks' => $request->remarks
                ?: 'Processing completed.',

        ]);

AuditLogger::log(
    'Incoming Documents',
    'Completed',
    Auth::user()->full_name .
    ' completed "' .
    $document->title .
    '".'
);

        return redirect()
            ->route('user.incoming')
            ->with(
                'success',
                'Document completed successfully.'
            );
    }
}