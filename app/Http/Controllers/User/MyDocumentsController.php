<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyDocumentsController extends Controller
{
    /**
     * Display the employee's submitted documents.
     */
  public function index(Request $request)
{
    $query = Document::where('submitted_by', Auth::id());

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('tracking_code', 'like', '%' . $request->search . '%')
              ->orWhere('title', 'like', '%' . $request->search . '%');

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Category Filter
    |--------------------------------------------------------------------------
    */

    if ($request->filled('category')) {

        $query->where('category', $request->category);

    }

    /*
    |--------------------------------------------------------------------------
    | Status Filter
    |--------------------------------------------------------------------------
    */

    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    /*
    |--------------------------------------------------------------------------
    | Load Documents
    |--------------------------------------------------------------------------
    */

    $documents = $query
        ->with([
            'submittedBy',
            'office',
            'reviewer',
            'receiverOffice',
            'logs.user',
        ])
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('user.my-documents', [

        'documents' => $documents,

        'submittedCount' => Document::where('submitted_by', Auth::id())->count(),

        'reviewCount' => Document::where('submitted_by', Auth::id())
            ->where('status', 'for_review')
            ->count(),

        'approvedCount' => Document::where('submitted_by', Auth::id())
            ->where('status', 'approved')
            ->count(),

        'returnedCount' => Document::where('submitted_by', Auth::id())
            ->whereIn('status', ['returned', 'rejected'])
            ->count(),

    ]);
}

    /**
     * Display documents forwarded directly to this employee by the admin.
     */
    public function received(Request $request)
    {
        $query = Document::where('sent_to', Auth::id());

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('tracking_code', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');

            });

        }

        $documents = $query
            ->with(['submittedBy'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.received-documents', [

            'documents' => $documents,

            'receivedCount' => Document::where('sent_to', Auth::id())->count(),

        ]);
    }

    /**
     * Display a single document.
     */
    public function show(Document $document)
    {
        // Allow access if the employee either submitted it OR it was forwarded to them
        abort_if(
            $document->submitted_by !== Auth::id() && $document->sent_to !== Auth::id(),
            403
        );

        $document->load([
            'submittedBy',
            'office',
            'receiverOffice',
            'reviewer',
            'logs.user',
        ]);

        return view('user.document-details', compact('document'));
    }
}