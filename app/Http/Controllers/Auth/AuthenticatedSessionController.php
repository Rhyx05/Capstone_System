<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate the extra "login_as" field from the dropdown.
        $request->validate([
            'login_as' => ['required', 'in:user,admin,record_keeper'],
        ]);

        // Authenticate credentials (Breeze's built-in method on LoginRequest).
        $request->authenticate();

        $request->session()->regenerate();

        $authenticatedUser = Auth::user();

        // Check that the selected portal matches the account's actual role.
        if ($authenticatedUser->role !== $request->login_as) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'login_as' => 'This account is not registered as ' .
                    ($request->login_as === 'admin' ? 'an Admin' : 'an Employee') . '. ' .
                    'Please select the correct portal.',
            ]);
        }

        // Block deactivated accounts.
        if (! $authenticatedUser->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Your account has been deactivated. Please contact the administrator.',
            ]);
        }

        // Temporary redirect until dashboards are built.
if ($authenticatedUser->role === 'admin') {
    return redirect()->route('admin.dashboard');
}

if ($authenticatedUser->role === 'record_keeper') {
    return redirect()->route('admin6.dashboard');
}

return redirect()->route('user.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}