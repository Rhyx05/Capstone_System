<x-layouts.admin-layout>

@if(session('success'))

<div class="rounded-xl bg-green-100 border border-green-300 text-green-700 p-4">

    {{ session('success') }}

</div>

@endif

@if(session('error'))

<div class="rounded-xl bg-red-100 border border-red-300 text-red-700 p-4">

    {{ session('error') }}

</div>

@endif

<div class="space-y-8">

    {{-- ====================================================== --}}
    {{-- PAGE HEADER --}}
    {{-- ====================================================== --}}

    <div class="flex items-start justify-between">

        <div>

            <a
                href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700">

                ← Back to User Management

            </a>

            <h1 class="mt-5 text-3xl font-bold text-gray-900">

                User Profile

            </h1>

            <p class="mt-2 text-gray-500">

                View complete user account information.

            </p>

        </div>

        <div>

            @if($user->is_active)

                <span class="inline-flex rounded-full bg-green-100 px-5 py-2 text-sm font-semibold text-green-700">

                    Active

                </span>

            @else

                <span class="inline-flex rounded-full bg-red-100 px-5 py-2 text-sm font-semibold text-red-700">

                    Inactive

                </span>

            @endif

        </div>

    </div>

    {{-- ====================================================== --}}
    {{-- USER DETAILS --}}
    {{-- ====================================================== --}}

    <div class="overflow-hidden rounded-2xl border bg-white shadow-sm">

        <div class="border-b px-6 py-4">

            <h2 class="text-xl font-bold text-gray-900">

                Account Information

            </h2>

        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-6 p-6 md:grid-cols-3">

            <div>

                <p class="text-xs uppercase tracking-wide text-gray-500">

                    Full Name

                </p>

                <p class="mt-1 font-semibold text-gray-900">

                    {{ $user->first_name }} {{ $user->last_name }}

                </p>

            </div>

            <div>

                <p class="text-xs uppercase tracking-wide text-gray-500">

                    Email

                </p>

                <p class="mt-1">

                    {{ $user->email }}

                </p>

            </div>

            <div>

                <p class="text-xs uppercase tracking-wide text-gray-500">

                    Office

                </p>

                <p class="mt-1">

                    {{ optional($user->office)->office_name ?? 'None' }}

                </p>

            </div>

            <div>

                <p class="text-xs uppercase tracking-wide text-gray-500">

                    Role

                </p>

                <p class="mt-1">

                    {{ ucfirst($user->role) }}

                </p>

            </div>

            <div>

                <p class="text-xs uppercase tracking-wide text-gray-500">

                    Registered

                </p>

                <p class="mt-1">

                    {{ $user->created_at->format('F d, Y h:i A') }}

                </p>

            </div>

            <div>

                <p class="text-xs uppercase tracking-wide text-gray-500">

                    Last Updated

                </p>

                <p class="mt-1">

                    {{ $user->updated_at->format('F d, Y h:i A') }}

                </p>

            </div>

        </div>

    </div>

    {{-- ====================================================== --}}
    {{-- ACTIONS --}}
    {{-- ====================================================== --}}

    <div class="rounded-2xl border bg-white shadow-sm p-6">

        <h2 class="mb-5 text-xl font-bold">

            Account Actions

        </h2>

        <div class="flex flex-wrap gap-4">

            @if($user->is_active)

                <form
                    action="{{ route('admin.users.deactivate',$user) }}"
                    method="POST">

                    @csrf

                    <button
                        class="rounded-xl bg-yellow-500 px-6 py-3 font-semibold text-white hover:bg-yellow-600">

                        Deactivate Account

                    </button>

                </form>

            @else

                <form
                    action="{{ route('admin.users.activate',$user) }}"
                    method="POST">

                    @csrf

                    <button
                        class="rounded-xl bg-green-600 px-6 py-3 font-semibold text-white hover:bg-green-700">

                        Activate Account

                    </button>

                </form>

            @endif

            <form
                action="{{ route('admin.users.destroy',$user) }}"
                method="POST"
                onsubmit="return confirm('Delete this account permanently?')">

                @csrf
                @method('DELETE')

                <button
                    class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white hover:bg-red-700">

                    Delete Account

                </button>

            </form>

        </div>

    </div>

</div>

</x-layouts.admin-layout>