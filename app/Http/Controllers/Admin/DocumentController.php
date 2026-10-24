<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\AuditLogger;
use App\Models\ElectronicFilingCategory;
use App\Helpers\NotificationHelper;
use App\Services\DocumentTextExtractor;

class DocumentController extends Controller
{
    /**
     * Show the admin's own document submission form.
     */

public function create()
{
    return view('admin.documents.create');
}

/**
 * Handle the admin's own document submission.
 */
public function store(Request $request, DocumentTextExtractor $extractor)
{
    $request->validate([
        'title'       => ['required', 'string', 'max:150'],
        'category'    => ['required', 'string', 'max:100'],
        'description' => ['nullable', 'string', 'max:1000'],
        'file'        => ['required', 'file', 'mimes:pdf,docx', 'max:10240'], // 10MB max
    ]);

    $uploadedFile = $request->file('file');

    // Extract from the uploaded temp file BEFORE storing it
    $extractedText = $extractor->extract(
        $uploadedFile->getRealPath(),
        $uploadedFile->getClientOriginalExtension()
    );

    $path = $uploadedFile->store('documents', 'public');

    $document = Document::create([
        'tracking_code'   => strtoupper(Str::random(8)),
        'title'           => $request->title,
        'category'        => $request->category,
        'description'     => $request->description,
        'extracted_text'  => $extractedText,
        'file_name'       => $uploadedFile->getClientOriginalName(),
        'file_path'       => $path,
        'file_type'       => $uploadedFile->getClientMimeType(),
        'file_size'       => $uploadedFile->getSize(),
        'submitted_by'    => Auth::id(),
        'office_id'       => Auth::user()->office_id,
        'status'          => 'for_review',
        'submission_date' => now(),
    ]);

    DocumentLog::create([
        'document_id' => $document->id,
        'user_id'     => Auth::id(),
        'action'      => 'Submitted',
        'remarks'     => 'Document submitted by Administrator.',
    ]);

    AuditLogger::log(
        'Documents',
        'Submitted',
        'Submitted document: ' . $document->title
    );

    return redirect()->route('admin.documents.index')
        ->with('success', 'Document submitted successfully.');
}

    /**
     * Display all submitted documents.
     */
public function index(Request $request)
{
    $documents = Document::with([
            'submittedBy',
            'office',
            'assignedUser',
            'receiverOffice',
        ])
        ->where('status', 'for_review');

    // Search
    if ($request->filled('search')) {

        $documents->where(function ($query) use ($request) {

            $query->where('tracking_code', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');

        });

    }

    // Status Filter
    if ($request->filled('status')) {

        $documents->where('status', $request->status);

    }

    // Priority Filter
    if ($request->filled('priority')) {

        $documents->where('priority', $request->priority);

    }

    // Sorting
    switch ($request->sort) {

        case 'oldest':
            $documents->oldest('submission_date');
            break;

        case 'title':
            $documents->orderBy('title');
            break;

        case 'priority':
            $documents->orderByRaw("
                FIELD(priority,'Urgent','High','Normal')
            ");
            break;

        default:
            $documents->latest('submission_date');
            break;

    }

    $documents = $documents
        ->paginate(10)
        ->withQueryString();

    return view('admin.documents.index', compact('documents'));
}
    /**
     * Display a single document.
     */
public function show(Document $document)
{
    $document->load([
        'submittedBy',
        'office',
        'receiverOffice',
        'assignedUser',
        'approver',
        'reviewer',
        'logs.user',
        'filingCategory',
    ])->loadCount('logs');

    $offices = Office::orderBy('office_name')->get();

    $users = User::with('office')
        ->where('role', 'user')
        ->where('is_active', true)
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get();

    // Electronic Filing Repositories
    $repositories = ElectronicFilingCategory::orderBy('name')->get();

    return view('admin.documents.show', compact(
        'document',
        'offices',
        'users',
        'repositories'
    ));
}

    /**
     * Approve document without routing.
     */
    public function approve(Request $request, Document $document)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);

       $document->update([

    'status' => 'completed',

    'approved_by' => Auth::id(),

    'approved_at' => now(),

    'reviewed_by' => Auth::id(),

    'reviewed_at' => now(),

    'remarks' => $request->remarks,

]);

        DocumentLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id(),

            'action' => 'Approved & Completed',

            'remarks' => $request->remarks
                ?: 'Document approved and completed by Administrator.',

        ]);

AuditLogger::log(
    'Documents',
    'Approved',
    Auth::user()->full_name .
    ' approved document "' .
    $document->title .
    '".'
);
NotificationHelper::notifyUser(

    $document->submitter,

    'Document Approved',

    'Your document "' .
    $document->title .
    '" has been approved.',

    'approved',

    $document

);

return redirect()
    ->route('admin.documents')
    ->with(
        'success',
        'Document approved successfully.'
    );
    }

    /**
     * Approve document and immediately route it to an employee.
     */
    public function approveAndRoute(Request $request, Document $document)
    {
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

        $employee = User::where('role', 'user')
            ->findOrFail($request->assigned_to);

        $document->update([

            'status' => 'assigned',

            'receiver_office_id' => $request->receiver_office_id,

            'assigned_to' => $employee->id,

            'assigned_at' => now(),

            'approved_by' => Auth::id(),

            'approved_at' => now(),

            'reviewed_by' => Auth::id(),

            'reviewed_at' => now(),

            'remarks' => $request->remarks,

        ]);

      DocumentLog::create([

    'document_id' => $document->id,

    'user_id' => Auth::id(),

    'action' => 'Approved & Routed',

    'remarks' =>
        'Approved and routed to '
        . $employee->full_name
        . '. '
        . ($request->remarks ?: ''),

]);

AuditLogger::log(
    'Documents',
    'Approved & Routed',
    Auth::user()->full_name .
    ' approved and routed "' .
    $document->title .
    '" to ' .
    $employee->full_name .
    '.'
);

/*
|--------------------------------------------------------------------------
| Notify Assigned Employee
|--------------------------------------------------------------------------
*/

NotificationHelper::notifyUser(

    $employee,

    'New Document Assigned',

    'A document "' .
    $document->title .
    '" has been assigned to you.',

    'assigned',

    $document

);

/*
|--------------------------------------------------------------------------
| Notify Original Submitter
|--------------------------------------------------------------------------
*/

NotificationHelper::notifyUser(

    $document->submitter,

    'Document Approved',

    'Your document "' .
    $document->title .
    '" has been approved and routed.',

    'approved',

    $document

);
return redirect()
    ->route('admin.documents')
    ->with(
        'success',
        'Document approved and routed successfully.'
    );
    }

    /**
     * Return document to the submitter.
     */
    public function returnDocument(Request $request, Document $document)
    {
        $request->validate([

            'remarks' => [
                'required',
                'string',
                'max:1000',
            ],

        ]);

        $document->update([

            'status' => 'returned',

            'reviewed_by' => Auth::id(),

            'reviewed_at' => now(),

            'remarks' => $request->remarks,

        ]);

        DocumentLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id(),

            'action' => 'Returned',

            'remarks' => $request->remarks,

        ]);

AuditLogger::log(
    'Documents',
    'Returned',
    Auth::user()->full_name .
    ' returned document "' .
    $document->title .
    '".'
);

NotificationHelper::notifyUser(

    $document->submitter,

    'Document Returned',

    'Your document "' .
    $document->title .
    '" has been returned for revision.',

    'returned',

    $document

);
return redirect()
    ->route('admin.documents')
    ->with(
        'success',
        'Document returned successfully.'
    );
    }


    /**
 * Show the form to forward a document to a designated employee.
 */
public function createForward()
{
    $employees = User::where('role', 'user')
        ->where('is_active', true)
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get();

    $forwardedDocuments = Document::with('sentTo')
        ->whereNotNull('sent_to')
        ->latest()
        ->paginate(10);

    return view('admin.forward', compact('employees', 'forwardedDocuments'));
}
/**
 * Handle forwarding a document to a designated employee.
 */
public function storeForward(Request $request, DocumentTextExtractor $extractor)
{
    $request->validate([
        'title'       => ['required', 'string', 'max:150'],
        'category'    => ['required', 'string', 'max:100'],
        'description' => ['nullable', 'string', 'max:1000'],
        'file'        => ['required', 'file', 'mimes:pdf,docx', 'max:10240'],
        'sent_to'     => ['required', 'exists:users,id'],
    ]);

    $uploadedFile = $request->file('file');

    // Extract from the uploaded temp file BEFORE storing it
    $extractedText = $extractor->extract(
        $uploadedFile->getRealPath(),
        $uploadedFile->getClientOriginalExtension()
    );

    $path = $uploadedFile->store('documents', 'public');

    // Receiver employee
    $receiver = User::with('office')->findOrFail($request->sent_to);

    $document = Document::create([
        'tracking_code'      => strtoupper(Str::random(8)),
        'title'              => $request->title,
        'category'           => $request->category,
        'description'        => $request->description,
        'extracted_text'     => $extractedText,
        'file_name'          => $uploadedFile->getClientOriginalName(),
        'file_path'          => $path,
        'file_type'          => $uploadedFile->getClientMimeType(),
        'file_size'          => $uploadedFile->getSize(),
        'submitted_by'       => Auth::id(),

        // Admin has no office
        'office_id'          => null,

        // Destination
        'receiver_office_id' => $receiver->office_id,
        'assigned_to'        => $receiver->id,
        'sent_to'            => $receiver->id,
        'assigned_at'        => now(),

        'status'             => 'assigned',
        'submission_date'    => now(),
    ]);

    DocumentLog::create([
        'document_id' => $document->id,
        'user_id'     => Auth::id(),
        'action'      => 'Forwarded',
        'remarks'     =>
            'Administrator forwarded this document to ' .
            $receiver->full_name .
            ' (' . optional($receiver->office)->office_name . ').',
    ]);

    AuditLogger::log(
        'Documents',
        'Forwarded',
        Auth::user()->full_name .
        ' forwarded "' .
        $document->title .
        '" to ' .
        $receiver->full_name .
        ' (' .
        optional($receiver->office)->office_name .
        ').'
    );

    NotificationHelper::notifyUser(
        $receiver,
        'New Document Assigned',
        'Administrator forwarded "' . $document->title . '" to you.',
        'assigned',
        $document
    );

    return redirect()
        ->route('admin.submit')
        ->with('success', 'Document forwarded successfully.');
}
}