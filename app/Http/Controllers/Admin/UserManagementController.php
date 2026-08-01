<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('office');

        // Search
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');

            });
        }

        // Office
        if ($request->filled('office')) {

            $query->where('office_id', $request->office);

        }

        // Role
        if ($request->filled('role')) {

            $query->where('role', $request->role);

        }

        // Status
        if ($request->filled('status')) {

            $query->where('is_active', $request->status);

        }

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [

            'users' => $users,

            'offices' => Office::orderBy('office_name')->get(),

            'totalUsers' => User::count(),

            'activeUsers' => User::where('is_active', true)->count(),

            'inactiveUsers' => User::where('is_active', false)->count(),

        ]);
    }

public function show(User $user)
{
    $user->load('office');

    return view('admin.users.show', compact('user'));
}
public function activate(User $user)
{
    $user->update([

        'is_active' => true,

    ]);

    return back()->with(
        'success',
        'User account activated successfully.'
    );
}

public function deactivate(User $user)
{
    if ($user->id == Auth::id()) {

        return back()->with(
            'error',
            'You cannot deactivate your own account.'
        );

    }

    $user->update([

        'is_active' => false,

    ]);

    return back()->with(
        'success',
        'User account deactivated successfully.'
    );
}

public function destroy(User $user)
{
    if ($user->id == Auth::id()) {

        return back()->with(
            'error',
            'You cannot delete your own account.'
        );

    }

    $user->delete();

    return redirect()
        ->route('admin.users.index')
        ->with(
            'success',
            'User account deleted successfully.'
        );
}
}