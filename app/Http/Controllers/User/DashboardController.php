<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $announcements = Announcement::with('author')
            ->where('is_published', true)
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->get();

        return view('user.dashboard', compact(
            'announcements'
        ));
    }
}