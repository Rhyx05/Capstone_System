<x-guest-layout>

<div class="w-full">

    {{-- Header --}}
    <div class="mb-8 text-center">

        {{-- Registration Success Message --}}
        @if (session('registration_success'))

            <div
                id="registrationSuccess"
                class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-4 text-left shadow-sm"
            >

                <div class="flex items-start gap-3">

                    <div
                        class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100"
                    >

                        <svg
                            class="h-5 w-5 text-green-600"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />

                        </svg>

                    </div>

                    <div>

                        <p class="font-semibold text-green-800">
                            Registration Successful
                        </p>

                        <p class="mt-1 text-sm text-green-700">
                            {{ session('registration_success') }}
                        </p>

                    </div>

                </div>

            </div>

        @endif


        {{-- Standard Session Status --}}
        <x-auth-session-status
            class="mb-4"
            :status="session('status')"
        />


        <h2 class="text-3xl font-bold text-gray-800">
            Login
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            Sign in to your account.
        </p>

    </div>


    {{-- Login Form --}}
    <form
        method="POST"
        action="{{ route('login') }}"
    >

        @csrf


        {{-- Login As --}}
        <div>

            <x-input-label
                for="login_as"
                value="Login As"
            />

            <select
                id="login_as"
                name="login_as"
                required
                class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >

                <option
                    value="user"
                    {{ old('login_as', 'user') === 'user' ? 'selected' : '' }}
                >
                    Employee
                </option>

                <option
                    value="admin"
                    {{ old('login_as') === 'admin' ? 'selected' : '' }}
                >
                    Administrator
                </option>

            </select>

            <x-input-error
                :messages="$errors->get('login_as')"
                class="mt-2"
            />

        </div>


        {{-- Email --}}
        <div class="mt-5">

            <x-input-label
                for="email"
                value="Email Address"
            />

            <x-text-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                class="mt-2 block w-full rounded-xl"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>


        {{-- Password --}}
        <div class="mt-5">

            <x-input-label
                for="password"
                value="Password"
            />

            <x-text-input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="mt-2 block w-full rounded-xl"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>


        {{-- Remember / Forgot Password --}}
        <div class="mt-5 flex items-center justify-between">

            <label class="flex items-center">

                <input
                    type="checkbox"
                    name="remember"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                >

                <span class="ml-2 text-sm text-gray-600">
                    Remember Me
                </span>

            </label>


            @if (Route::has('password.request'))

                <a
                    href="{{ route('password.request') }}"
                    class="text-sm text-blue-600 hover:text-blue-800"
                >
                    Forgot Password?
                </a>

            @endif

        </div>


        {{-- Login Button --}}
        <button
            type="submit"
            class="mt-8 w-full rounded-xl bg-gradient-to-r from-blue-700 to-indigo-700 py-3 font-semibold text-white transition hover:scale-[1.02] hover:shadow-xl"
        >
            Login
        </button>


        {{-- Register --}}
        <div class="mt-6 text-center text-sm text-gray-600">

            Don't have an account?

            <a
                href="{{ route('register') }}"
                class="font-semibold text-blue-600 hover:text-blue-800"
            >
                Register as Employee
            </a>

        </div>

    </form>

</div>


{{-- Registration Success Popup --}}
@if (session('registration_success'))

<script>

document.addEventListener('DOMContentLoaded', function () {

    const message = document.getElementById('registrationSuccess');

    if (!message) {
        return;
    }

    setTimeout(function () {

        message.style.transition = 'opacity 0.5s ease';

        message.style.opacity = '0';

        setTimeout(function () {

            message.remove();

        }, 500);

    }, 6000);

});

</script>

@endif

</x-guest-layout>