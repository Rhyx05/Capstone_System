<x-layouts.admin-layout>

<div class="max-w-6xl mx-auto">

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">User Management</h1>
                    <p class="mt-0.5 text-sm text-gray-500">Manage all registered employee and administrator accounts.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Statistics --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 p-6">

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 text-lg">👥</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Total Accounts</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600 text-lg">✅</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Active Accounts</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $activeUsers }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600 text-lg">⛔</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Inactive Accounts</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $inactiveUsers }}</h2>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Filters: search + office + role + status — auto-filters the table live --}}
        <form method="GET" action="{{ url()->current() }}" id="filterForm" class="px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center gap-3">

                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    value="{{ request('search') }}"
                    placeholder="Search user..."
                    autocomplete="off"
                    class="flex-1 rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                <select name="office" id="officeSelect" class="rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-48">
                    <option value="">All Offices</option>
                    @foreach($offices as $office)
                        <option value="{{ $office->id }}" @selected(request('office')==$office->id)>
                            {{ $office->office_name }}
                        </option>
                    @endforeach
                </select>

                <select name="role" id="roleSelect" class="rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-44">
                    <option value="">All Roles</option>
                    <option value="admin" @selected(request('role')=='admin')>Administrator</option>
                    <option value="user" @selected(request('role')=='user')>Employee</option>
                </select>

                <select name="status" id="statusSelect" class="rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-40">
                    <option value="">All Status</option>
                    <option value="1" @selected(request('status')==='1')>Active</option>
                    <option value="0" @selected(request('status')==='0')>Inactive</option>
                </select>

            </div>
        </form>

        <div class="border-t border-gray-100"></div>

        {{-- Table --}}
        @if($users->count())

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3.5 text-left">Name</th>
                            <th class="px-6 py-3.5 text-left">Email</th>
                            <th class="px-6 py-3.5 text-left">Office</th>
                            <th class="px-6 py-3.5 text-center">Role</th>
                            <th class="px-6 py-3.5 text-center">Status</th>
                            <th class="px-6 py-3.5 text-center">Registered</th>
                            <th class="px-6 py-3.5 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ optional($user->office)->office_name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($user->role == 'admin')
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border bg-purple-50 text-purple-700 border-purple-200">
                                            Administrator
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border bg-blue-50 text-blue-700 border-blue-200">
                                            Employee
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($user->is_active)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border bg-green-50 text-green-700 border-green-200">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border bg-red-50 text-red-700 border-red-200">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center text-gray-500 text-xs">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a
                                        href="{{ route('admin.users.show', $user) }}"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition">
                                        View
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

            @if($users->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @endif

        @else

            {{-- Empty State --}}
            <div class="px-8 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 border border-gray-200 text-2xl mb-4">
                    👥
                </div>
                <h2 class="text-base font-semibold text-gray-900">No Users Found</h2>
                <p class="text-sm text-gray-500 mt-1">
                    @if(request('search') || request('office') || request('role') || request('status') !== null)
                        No users match your search or filter.
                    @else
                        No accounts have been registered yet.
                    @endif
                </p>
            </div>

        @endif

    </div>

</div>

<script>
(function () {
    const form = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const officeSelect = document.getElementById('officeSelect');
    const roleSelect = document.getElementById('roleSelect');
    const statusSelect = document.getElementById('statusSelect');
    let debounceTimer;

    // Live filter as the user types (debounced so it doesn't submit on every keystroke)
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            form.submit();
        }, 500);
    });

    // Instant filter when any dropdown changes
    [officeSelect, roleSelect, statusSelect].forEach(function (select) {
        select.addEventListener('change', function () {
            form.submit();
        });
    });
})();
</script>

</x-layouts.admin-layout>