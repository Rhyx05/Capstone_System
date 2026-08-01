<x-guest-layout>
    <!-- Session Status -->
  <div class="w-full">

    <div class="mb-8 text-center">
  
    <x-auth-session-status class="mb-4" :status="session('status')" />

        <h2 class="text-3xl font-bold text-gray-800">

        Login

        </h1>

    </div>

           <form method="POST" action="{{ route('login') }}">

            @csrf

            {{-- Login As --}}
            <div>

                <x-input-label for="login_as" value="Login As"/>

                <select
                    id="login_as"
                    name="login_as"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">

                    <option value="user" {{ old('login_as','user')=='user'?'selected':'' }}>
                        Employee
                    </option>

                    <option value="admin" {{ old('login_as')=='admin'?'selected':'' }}>
                        Administrator
                    </option>

                </select>

                <x-input-error :messages="$errors->get('login_as')" class="mt-2"/>

            </div>

            {{-- Email --}}
            <div class="mt-5">

                <x-input-label for="email" value="Email Address"/>

                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    class="block mt-2 w-full rounded-xl"/>

                <x-input-error :messages="$errors->get('email')" class="mt-2"/>

            </div>

            {{-- Password --}}
            <div class="mt-5">

                <x-input-label for="password" value="Password"/>

                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="block mt-2 w-full rounded-xl"/>

                <x-input-error :messages="$errors->get('password')" class="mt-2"/>

            </div>

            {{-- Remember --}}
            <div class="mt-5 flex items-center justify-between">

                <label class="flex items-center">

                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                    <span class="ml-2 text-sm text-gray-600">

                        Remember Me

                    </span>

                </label>

                @if(Route::has('password.request'))

                <a
                    href="{{ route('password.request') }}"
                    class="text-sm text-blue-600 hover:text-blue-800">

                    Forgot Password?

                </a>

                @endif

            </div>

            {{-- Login Button --}}
            <button
                type="submit"
                class="mt-8 w-full rounded-xl bg-gradient-to-r from-blue-700 to-indigo-700 py-3 font-semibold text-white transition hover:scale-[1.02] hover:shadow-xl">

                Login

            </button>

            {{-- Register --}}
            <div class="mt-6 text-center text-sm text-gray-600">

                Don't have an account?

                <a
                    href="{{ route('register') }}"
                    class="font-semibold text-blue-600 hover:text-blue-800">

                    Register

                </a>

            </div>

        </form>

        </div>
</x-guest-layout>