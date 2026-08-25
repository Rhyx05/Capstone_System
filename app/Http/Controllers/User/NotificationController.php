<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Notification Center
     */
    public function index(): View
    {
        $notifications = Notification::where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(15);

        return view(
            'user.notifications.index',
            compact('notifications')
        );
    }

    /**
     * Mark one notification as read.
     */
  public function markAsRead(Request $request, Notification $notification)
{
    abort_if($notification->user_id != Auth::id(), 403);

    if (!$notification->is_read) {
        $notification->update(['is_read' => true]);
    }

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json(['success' => true]);
    }

    if ($notification->document_id) {

        // Assignment notifications go to Incoming; everything else goes to My Documents
        if ($notification->type === 'assigned') {
            return redirect()->route('user.incoming.show', $notification->document_id);
        }

        return redirect()->route('user.documents.show', $notification->document_id);
    }

    return redirect()->route('user.notifications.index');
}
    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {

        Notification::where(
            'user_id',
            Auth::id()
        )
        ->where('is_read', false)
        ->update([
            'is_read' => true
        ]);

        if ($request->ajax() || $request->wantsJson()) {

            return response()->json([
                'success' => true
            ]);

        }

        return back()->with(
            'success',
            'All notifications marked as read.'
        );

    }

    /**
     * Live notifications.
     */
  public function live()
{
    $notifications = Notification::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->take(5)
        ->get()
        ->map(function ($notification) {

            return [

                'id' => $notification->id,

                'title' => $notification->title,

                'message' => $notification->message,

                'type' => $notification->type,

                'document_id' => $notification->document_id,

                'is_read' => $notification->is_read,

                'time' => $notification->created_at->diffForHumans(),

            ];

        });

    return response()->json([

        'count' => Notification::where(
                'user_id',
                auth()->id()
            )
            ->where('is_read', false)
            ->count(),

        'notifications' => $notifications,

    ]);
}
}