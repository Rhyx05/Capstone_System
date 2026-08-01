<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Employee History Logs
     */
    public function index(Request $request)
    {
        $query = DocumentLog::with([
                'document',
                'user'
            ])
            ->where('user_id', Auth::id());

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->whereHas('document', function ($q) use ($request) {

                $q->where('tracking_code', 'like', "%{$request->search}%")
                  ->orWhere('title', 'like', "%{$request->search}%");

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Action Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('action')) {

            $query->where('action', $request->action);

        }

        $logs = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Cards
        |--------------------------------------------------------------------------
        */

        $submitted = Document::where('submitted_by', Auth::id())->count();

        $processed = DocumentLog::where('user_id', Auth::id())
            ->whereIn('action', [
                'Completed',
                'Forwarded'
            ])
            ->count();

        $approved = DocumentLog::where('user_id', Auth::id())
            ->whereIn('action', [
                'Completed',
                'Forwarded'
            ])
            ->count();

        $rejected = DocumentLog::where('user_id', Auth::id())
            ->where('action', 'Rejected')
            ->count();

        return view('user.history', compact(

            'logs',

            'submitted',

            'processed',

            'approved',

            'rejected'

        ));
    }
}