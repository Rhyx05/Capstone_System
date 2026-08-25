<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display Notification Center.
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
            'admin.notifications.index',
            compact('notifications')
        );
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(
        Request $request,
        Notification $notification
    ) {
        abort_if(
            $notification->user_id !== Auth::id(),
            403
        );

        if (!$notification->is_read) {

            $notification->update([
                'is_read' => true,
            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | AJAX Request
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Redirect to Related Document
        |--------------------------------------------------------------------------
        */

        if ($notification->document_id) {

            return redirect()->route(
                'admin.documents.show',
                $notification->document_id
            );

        }

        return redirect()->route(
            'admin.notifications.index'
        );
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
            'is_read' => true,
        ]);

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
            ]);

        }

        return back()->with(
            'success',
            'All notifications marked as read.'
        );
    }

    /**
     * Live Notifications API
     */
    public function live(): JsonResponse
    {
        $notifications = Notification::where(
                'user_id',
                Auth::id()
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

                    /*
                    |--------------------------------------------------------------------------
                    | URL to open after clicking notification
                    |--------------------------------------------------------------------------
                    */

                    'url' => $notification->document_id
                        ? route(
                            'admin.documents.show',
                            $notification->document_id
                        )
                        : route(
                            'admin.notifications.index'
                        ),

                    /*
                    |--------------------------------------------------------------------------
                    | AJAX Read URL
                    |--------------------------------------------------------------------------
                    */

                    'read_url' => route(
                        'admin.notifications.read',
                        $notification->id
                    ),

                ];

            });

        $unreadCount = Notification::where(
                'user_id',
                Auth::id()
            )
            ->where('is_read', false)
            ->count();

        return response()->json([

            'count' => $unreadCount,

            'notifications' => $notifications,

        ]);
    }
}