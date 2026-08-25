<x-guest-layout>

<div class="w-full">

    {{-- Header --}}
    <div class="mb-8 text-center">

        <h2 class="text-3xl font-bold text-gray-800">
            Create Employee Account
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            Register as an employee to access the document management system.
        </p>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4">

            <div class="font-semibold text-red-700">
                Please correct the following errors:
            </div>

            <ul class="mt-2 list-disc pl-5 text-sm text-red-600">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Registration Form --}}
    <form
        method="POST"
        action="{{ route('register') }}"
        class="space-y-4"
    >

        @csrf


        {{-- First Name / Last Name --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            {{-- First Name --}}
            <div>

                <x-input-label
                    for="first_name"
                    :value="'First Name'"
                />

                <x-text-input
                    id="first_name"
                    class="mt-1 block w-full rounded-xl"
                    type="text"
                    name="first_name"
                    :value="old('first_name')"
                    required
                    autofocus
                    autocomplete="given-name"
                />

                <x-input-error
                    :messages="$errors->get('first_name')"
                    class="mt-2"
                />

            </div>


            {{-- Last Name --}}
            <div>

                <x-input-label
                    for="last_name"
                    :value="'Last Name'"
                />

                <x-text-input
                    id="last_name"
                    class="mt-1 block w-full rounded-xl"
                    type="text"
                    name="last_name"
                    :value="old('last_name')"
                    required
                    autocomplete="family-name"
                />

                <x-input-error
                    :messages="$errors->get('last_name')"
                    class="mt-2"
                />

            </div>

        </div>


        {{-- Office --}}
        <div>

            <x-input-label
                for="office_id"
                :value="'Office'"
            />

            <select
                id="office_id"
                name="office_id"
                required
                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >

                <option value="">
                    Select Office
                </option>

                @foreach ($offices as $office)

                    <option
                        value="{{ $office->id }}"
                        {{ old('office_id') == $office->id ? 'selected' : '' }}
                    >
                        {{ $office->office_name }}
                    </option>

                @endforeach

            </select>

            <x-input-error
                :messages="$errors->get('office_id')"
                class="mt-2"
            />

        </div>


        {{-- Email --}}
        <div>

            <x-input-label
                for="email"
                :value="'Email Address'"
            />

            <x-text-input
                id="email"
                class="mt-1 block w-full rounded-xl"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>


        {{-- Password / Confirmation --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            {{-- Password --}}
            <div>

                <x-input-label
                    for="password"
                    :value="'Password'"
                />

                <x-text-input
                    id="password"
                    class="mt-1 block w-full rounded-xl"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />

                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2"
                />

            </div>


            {{-- Confirm Password --}}
            <div>

                <x-input-label
                    for="password_confirmation"
                    :value="'Confirm Password'"
                />

                <x-text-input
                    id="password_confirmation"
                    class="mt-1 block w-full rounded-xl"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <x-input-error
                    :messages="$errors->get('password_confirmation')"
                    class="mt-2"
                />

            </div>

        </div>


        {{-- Employee Notice --}}
        <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">


        </div>


        {{-- Create Account --}}
        <button
            type="submit"
            class="w-full rounded-xl bg-gradient-to-r from-blue-700 to-indigo-700 py-3 font-semibold text-white transition hover:scale-[1.01] hover:shadow-lg"
        >
            Create Employee Account
        </button>


        {{-- Login --}}
        <div class="pt-3 text-center text-sm text-gray-600">

            Already have an account?

            <a
                href="{{ route('login') }}"
                class="font-semibold text-blue-700 hover:text-blue-900"
            >
                Login here
            </a>

        </div>

    </form>

</div>

</x-guest-layout>