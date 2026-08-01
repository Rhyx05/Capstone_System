<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public static function log(
        string $module,
        string $action,
        string $description
    ): void {

AuditLog::create([

    'user_id' => Auth::id(),

    'module' => $module,

    'action' => $action,

    'description' => $description,

    'created_at' => now(),

]);

    }
}