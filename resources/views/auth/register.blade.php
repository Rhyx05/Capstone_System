<x-guest-layout>

<div class="w-full">

    <div class="mb-8 text-center">

        <h2 class="text-3xl font-bold text-gray-800">
            Create Account
        </h2>

    </div>

  <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf

<div class="grid grid-cols-2 gap-4">

    {{-- First Name --}}
    <div>
        <x-input-label for="first_name" :value="'First Name'" />
        <x-text-input
            id="first_name"
            class="mt-1 w-full rounded-xl"
            type="text"
            name="first_name"
            :value="old('first_name')"
            required
        />
    </div>

    {{-- Last Name --}}
    <div>
        <x-input-label for="last_name" :value="'Last Name'" />
        <x-text-input
            id="last_name"
            class="mt-1 w-full rounded-xl"
            type="text"
            name="last_name"
            :value="old('last_name')"
            required
        />
    </div>

    {{-- Role --}}
    <div>
        <x-input-label for="role" :value="'Register As'" />

        <select
            id="role"
            name="role"
            class="mt-1 w-full rounded-xl border-gray-300">

            <option value="user">Employee</option>
            <option value="admin">Administrator</option>

        </select>
    </div>

    {{-- Office --}}
    <div>
        <x-input-label for="office_id" :value="'Office'" />

        <select
            id="office_id"
            name="office_id"
            class="mt-1 w-full rounded-xl border-gray-300">

            <option>Select Office</option>

            @foreach($offices as $office)
                <option value="{{ $office->id }}">
                    {{ $office->office_name }}
                </option>
            @endforeach

        </select>
    </div>

</div>

<div>

    <x-input-label for="email" :value="'Email Address'" />

    <x-text-input
        id="email"
        class="mt-1 w-full rounded-xl"
        type="email"
        name="email"
        :value="old('email')"
        required
    />

</div>

<div class="grid grid-cols-2 gap-4">

    <div>

        <x-input-label for="password" :value="'Password'" />

        <x-text-input
            id="password"
            class="mt-1 w-full rounded-xl"
            type="password"
            name="password"
            required
        />

    </div>

    <div>

        <x-input-label
            for="password_confirmation"
            :value="'Confirm Password'"
        />

        <x-text-input
            id="password_confirmation"
            class="mt-1 w-full rounded-xl"
            type="password"
            name="password_confirmation"
            required
        />

    </div>

</div>



        {{-- Button --}}
<button
    type="submit"
    class="w-full rounded-xl bg-blue-700 py-2.5 text-white font-semibold hover:bg-blue-800">

    Create Account

</button>

        {{-- Login --}}
        <div class="pt-3 text-center text-sm text-gray-600">

            Already have an account?

            <a
                href="{{ route('login') }}"
                class="font-semibold text-blue-700 hover:text-blue-900">

                Login here

            </a>

        </div>

    </form>

</div>

</x-guest-layout>