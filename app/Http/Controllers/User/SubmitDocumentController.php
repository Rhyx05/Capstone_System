<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentLog;
use App\Services\DocumentTextExtractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditLogger;
use App\Helpers\NotificationHelper;

class SubmitDocumentController extends Controller
{
    /**
     * Display the Submit Document page.
     */
    public function create()
    {
        return view('user.submit');
    }

    /**
     * Handle document upload.
     */
    public function store(Request $request, DocumentTextExtractor $extractor)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'priority' => [
                'required',
                'in:Low,Normal,High,Urgent',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'document' => [
                'required',
                'mimes:pdf,doc,docx',
                'max:10240', // 10 MB
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload File
        |--------------------------------------------------------------------------
        */

 $file = $request->file('document');
$extension = strtolower($file->getClientOriginalExtension());

// Extract from the uploaded temp file, before storing
$extractedText = $extractor->extract($file->getRealPath(), $extension);

$path = $file->store('documents', 'public');

        /*
        |--------------------------------------------------------------------------
        | Generate Tracking Code
        |--------------------------------------------------------------------------
        */

        $trackingCode = 'DOC-'
            . date('Ymd')
            . '-'
            . str_pad((Document::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        /*
        |--------------------------------------------------------------------------
        | Save Document
        |--------------------------------------------------------------------------
        */

        $document = Document::create([

            'tracking_code' => $trackingCode,

            'title' => $request->title,

            'category' => $request->category,

            'priority' => $request->priority,

            'description' => $request->description,

            'extracted_text' => $extractedText,

            'file_name' => $file->getClientOriginalName(),

            'file_path' => $path,

            'file_type' => strtolower($file->getClientOriginalExtension()),

            'file_size' => $file->getSize(),

            'submitted_by' => Auth::id(),

            'office_id' => Auth::user()->office_id,

            'status' => 'for_review',

            'submission_date' => now(),

        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Initial Document Log
        |--------------------------------------------------------------------------
        */

DocumentLog::create([

    'document_id' => $document->id,

    'user_id' => Auth::id(),

    'action' => 'Submitted',

    'remarks' =>
        Auth::user()->full_name .
        ' from the Office of ' .
        optional(Auth::user()->office)->office_name .
        ' submitted the document.',

]);


AuditLogger::log(
    'Documents',
    'Submitted',
    Auth::user()->full_name .
    ' submitted document "' .
    $document->title .
    '".'
);

NotificationHelper::notifyAdmins(
    'New Document Submitted',
    Auth::user()->full_name .
    ' submitted "' .
    $document->title .
    '".',
    'document',
    $document
);

return redirect()
    ->route('user.submit')
    ->with(
        'success',
        "Document submitted successfully. Tracking Code: {$trackingCode}"
    );
    }
}