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
     * Display the employee registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'offices' => Office::orderBy('office_name')->get(),
        ]);
    }

    /**
     * Handle an incoming employee registration request.
     *
     * Public registration is for employees only.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'office_id' => [
                'required',
                'exists:offices,id',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Employee Account
        |--------------------------------------------------------------------------
        |
        | The role is deliberately NOT taken from the request.
        | Every account created through public registration is an employee.
        |
        */

        $user = User::create([
            'first_name' => $request->first_name,

            'last_name' => $request->last_name,

            'email' => $request->email,

            'office_id' => $request->office_id,

            'role' => 'user',

            'is_active' => true,

            'password' => Hash::make($request->password),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Registered Event
        |--------------------------------------------------------------------------
        */

        event(new Registered($user));

        /*
        |--------------------------------------------------------------------------
        | Redirect To Login
        |--------------------------------------------------------------------------
        |
        | The employee is NOT automatically logged in.
        | A success message is stored in the session and displayed
        | by the login page.
        |
        */

        return redirect()
            ->route('login')
            ->with(
                'registration_success',
                'Registration successful! Your employee account has been created. You can now log in.'
            );
    }
}