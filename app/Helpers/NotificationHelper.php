<?php

namespace App\Helpers;

use App\Models\Document;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationHelper
{
    public static function notifyAdmins(
        string $title,
        string $message,
        string $type = 'document',
        ?Document $document = null
    ): void {

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {

            try {

                Notification::create([
                    'user_id' => $admin->id,
                    'title' => $title,
                    'message' => $message,
                    'type' => $type,
                    'document_id' => $document?->id,
                    'is_read' => false,
                ]);

            } catch (\Exception $e) {

                Log::error($e->getMessage());

                dd($e->getMessage());

            }

        }

    }

    /**
 * Notify a specific user.
 */
public static function notifyUser(
    ?User $user,
    string $title,
    string $message,
    string $type = 'document',
    ?Document $document = null
): void {

    if (!$user) {
        return;
    }

    Notification::create([

        'user_id' => $user->id,

        'title' => $title,

        'message' => $message,

        'type' => $type,

        'document_id' => $document?->id,

        'is_read' => false,

    ]);
}
}