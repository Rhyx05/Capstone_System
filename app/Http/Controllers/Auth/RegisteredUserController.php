<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'offices' => Office::orderBy('office_name')->get(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'role'       => ['required', 'in:user,admin,admin6'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'office_id'  => ['required', 'exists:offices,id'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Saves ALL submitted data to the database.
$user = User::create([
    'first_name' => $request->first_name,
    'last_name'  => $request->last_name,
    'email'      => $request->email,
    'office_id'  => $request->office_id,
    'role'       => $request->role,
    'is_active'  => true,
    'password'   => Hash::make($request->password),
]);

        event(new Registered($user));

        // Does NOT log the user in. Sends them to the login page instead.
        return redirect()->route('login')
            ->with('status', 'Registration successful! Please log in with your new account.');
    }
}