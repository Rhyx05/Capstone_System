<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditLogger;

class AnnouncementController extends Controller
{
    /**
     * Display all announcements.
     */
    public function index()
    {
        $announcements = Announcement::with('author')
            ->latest()
            ->paginate(10);

        return view(
            'admin.announcements.index',
            compact('announcements')
        );
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store announcement.
     */
    public function store(Request $request)
    {
        $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'content' => [
                'required',
                'string',
            ],

            'is_published' => [
                'nullable',
                'boolean',
            ],

            'is_pinned' => [
                'nullable',
                'boolean',
            ],

        ]);

        Announcement::create([

            'title' => $request->input('title'),

            'content' => $request->input('content'),

            'created_by' => Auth::id(),

            'is_published' => $request->boolean('is_published'),

            'is_pinned' => $request->boolean('is_pinned'),

            'published_at' => now(),

        ]);

return redirect()
    ->route('admin.announcements')
    ->with(
        'success',
        'Announcement posted successfully.'
    );
    }

    /**
     * Edit form.
     */
    public function edit(Announcement $announcement)
    {
        return view(
            'admin.announcements.edit',
            compact('announcement')
        );
    }

    /**
     * Update announcement.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'content' => [
                'required',
                'string',
            ],

        ]);

        $announcement->update([

            'title' => $request->input('title'),

            'content' => $request->input('content'),

            'is_published' => $request->boolean('is_published'),

            'is_pinned' => $request->boolean('is_pinned'),

        ]);

return redirect()
    ->route('admin.announcements')
    ->with(
        'success',
        'Announcement updated successfully.'
    );
    }

    /**
     * Delete announcement.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return back()->with(
            'success',
            'Announcement deleted.'
        );
    }
}