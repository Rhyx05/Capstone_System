<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Document;

class AuditController extends Controller
{
   public function index(Request $request)
{
    $documents = Document::with([

        'submittedBy.office',

        'logs.user.office',

    ])
    ->latest('submission_date')
    ->paginate(10);

    return view('admin.audit', [

        'documents' => $documents,

        'totalLogs' => AuditLog::count(),

        'todayLogs' => AuditLog::whereDate(
            'created_at',
            today()
        )->count(),

        'weekLogs' => AuditLog::whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )->count(),

        'activeAdmins' => User::where('role', 'admin')->count(),

    ]);
}

    public function documentDetails(Document $document)
{
    $document->load([
        'submittedBy.office',
        'office',
        'logs.user.office',
    ]);

    return view(
        'admin.partials.audit-document-modal',
        compact('document')
    );
}

public function timeline(Document $document)
{
    $document->load([
        'submittedBy.office',
        'logs.user.office'
    ]);

    return view(
        'admin.partials.timeline',
        compact('document')
    );
}
}