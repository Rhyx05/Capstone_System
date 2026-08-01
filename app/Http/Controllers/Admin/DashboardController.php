<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $announcements = Announcement::with('author')
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'announcements'
        ));
    }
}