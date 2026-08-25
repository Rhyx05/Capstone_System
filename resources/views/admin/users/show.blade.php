<x-layouts.admin-layout>

<div class="max-w-6xl mx-auto">

@if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
        <span class="text-lg">✅</span>
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
        <span class="text-lg">⚠️</span>
        <p class="text-sm text-red-700">{{ session('error') }}</p>
    </div>
@endif

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">User Profile</h1>
                        <p class="mt-0.5 text-sm text-gray-500">View complete user account information.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">

                    @if($user->is_active)
                        <span class="px-4 py-2 rounded-full text-xs font-semibold border bg-green-50 text-green-700 border-green-200">
                            Active
                        </span>
                    @else
                        <span class="px-4 py-2 rounded-full text-xs font-semibold border bg-red-50 text-red-700 border-red-200">
                            Inactive
                        </span>
                    @endif

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:border-indigo-200 hover:text-indigo-600 transition">
                        <span>←</span> Back
                    </a>

                </div>

            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- ===================================================== --}}
        {{-- ACCOUNT INFORMATION --}}
        {{-- ===================================================== --}}
        <div class="px-8 py-6">

            <div class="flex items-center gap-2 mb-5">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-sm">🪪</span>
                <h2 class="text-base font-semibold text-gray-900">Account Information</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Full Name</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->first_name }} {{ $user->last_name }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Email</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->email }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Office</p>
                    <p class="text-sm font-semibold text-gray-800">{{ optional($user->office)->office_name ?? 'None' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Role</p>
                    <p class="text-sm font-semibold text-gray-800">{{ ucfirst($user->role) }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Registered</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->created_at->format('F d, Y h:i A') }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Last Updated</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->updated_at->format('F d, Y h:i A') }}</p>
                </div>

            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- ===================================================== --}}
        {{-- ACCOUNT ACTIONS --}}
        {{-- ===================================================== --}}
        <div class="px-8 py-6">

            <div class="flex items-center gap-2 mb-5">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-purple-50 text-purple-600 text-sm">⚙️</span>
                <h2 class="text-base font-semibold text-gray-900">Account Actions</h2>
            </div>

            <div class="flex flex-wrap gap-3">

                @if($user->is_active)
                    <form action="{{ route('admin.users.deactivate', $user) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="flex items-center gap-2 rounded-xl bg-yellow-500 hover:bg-yellow-600 px-6 py-2.5 text-sm font-semibold text-white transition">
                            Deactivate Account
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.users.activate', $user) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="flex items-center gap-2 rounded-xl bg-green-600 hover:bg-green-700 px-6 py-2.5 text-sm font-semibold text-white transition">
                            Activate Account
                        </button>
                    </form>
                @endif

                <form
                    action="{{ route('admin.users.destroy', $user) }}"
                    method="POST"
                    onsubmit="return confirm('Delete this account permanently?')">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="flex items-center gap-2 rounded-xl bg-red-600 hover:bg-red-700 px-6 py-2.5 text-sm font-semibold text-white transition">
                        Delete Account
                    </button>
                </form>

            </div>

        </div>

    </div>

</div>

</x-layouts.admin-layout>