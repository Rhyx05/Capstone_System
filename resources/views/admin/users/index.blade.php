<x-layouts.admin-layout>

<div class="space-y-8">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div>

        <h1 class="text-3xl font-bold text-gray-900">

            User Management

        </h1>

        <p class="mt-2 text-gray-500">

            Manage all registered employee and administrator accounts.

        </p>

    </div>

    {{-- ========================================================= --}}
    {{-- SUMMARY CARDS --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="rounded-2xl bg-white border shadow-sm p-6">

            <p class="text-gray-500 text-sm">

                Total Accounts

            </p>

            <h2 class="mt-2 text-4xl font-bold text-blue-700">

                {{ $totalUsers }}

            </h2>

        </div>

        <div class="rounded-2xl bg-white border shadow-sm p-6">

            <p class="text-gray-500 text-sm">

                Active Accounts

            </p>

            <h2 class="mt-2 text-4xl font-bold text-green-600">

                {{ $activeUsers }}

            </h2>

        </div>

        <div class="rounded-2xl bg-white border shadow-sm p-6">

            <p class="text-gray-500 text-sm">

                Inactive Accounts

            </p>

            <h2 class="mt-2 text-4xl font-bold text-red-600">

                {{ $inactiveUsers }}

            </h2>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- SEARCH + FILTERS --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-2xl border shadow-sm p-6">

        <form method="GET">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                {{-- Search --}}
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search user..."
                    class="rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                {{-- Office --}}
                <select
                    name="office"
                    class="rounded-xl border-gray-300 focus:ring-blue-500">

                    <option value="">

                        All Offices

                    </option>

                    @foreach($offices as $office)

                        <option
                            value="{{ $office->id }}"
                            {{ request('office')==$office->id ? 'selected':'' }}>

                            {{ $office->office_name }}

                        </option>

                    @endforeach

                </select>

                {{-- Role --}}
                <select
                    name="role"
                    class="rounded-xl border-gray-300">

                    <option value="">

                        All Roles

                    </option>

                    <option
                        value="admin"
                        {{ request('role')=='admin'?'selected':'' }}>

                        Administrator

                    </option>

                    <option
                        value="user"
                        {{ request('role')=='user'?'selected':'' }}>

                        Employee

                    </option>

                </select>

                {{-- Status --}}
                <select
                    name="status"
                    class="rounded-xl border-gray-300">

                    <option value="">

                        All Status

                    </option>

                    <option
                        value="1"
                        {{ request('status')==='1'?'selected':'' }}>

                        Active

                    </option>

                    <option
                        value="0"
                        {{ request('status')==='0'?'selected':'' }}>

                        Inactive

                    </option>

                </select>

                <button
                    class="rounded-xl bg-blue-600 text-white hover:bg-blue-700">

                    Search

                </button>

            </div>

        </form>

    </div>

    {{-- ========================================================= --}}
    {{-- USER TABLE --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left font-semibold">

                            Name

                        </th>

                        <th class="px-6 py-4 text-left font-semibold">

                            Email

                        </th>

                        <th class="px-6 py-4 text-left font-semibold">

                            Office

                        </th>

                        <th class="px-6 py-4 text-center font-semibold">

                            Role

                        </th>

                        <th class="px-6 py-4 text-center font-semibold">

                            Status

                        </th>

                        <th class="px-6 py-4 text-center font-semibold">

                            Registered

                        </th>

                        <th class="px-6 py-4 text-center font-semibold">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-6 py-4 font-medium">

                            {{ $user->first_name }}

                            {{ $user->last_name }}

                        </td>

                        <td class="px-6 py-4">

                            {{ $user->email }}

                        </td>

                        <td class="px-6 py-4">

                            {{ optional($user->office)->office_name }}

                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($user->role=='admin')

                                <span class="rounded-full bg-purple-100 text-purple-700 px-3 py-1 text-xs font-semibold">

                                    Administrator

                                </span>

                            @else

                                <span class="rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-semibold">

                                    Employee

                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($user->is_active)

                                <span class="rounded-full bg-green-100 text-green-700 px-3 py-1 text-xs font-semibold">

                                    Active

                                </span>

                            @else

                                <span class="rounded-full bg-red-100 text-red-700 px-3 py-1 text-xs font-semibold">

                                    Inactive

                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">

                            {{ $user->created_at->format('M d, Y') }}

                        </td>

                        <td class="px-6 py-4 text-center">

                            <a
                                href="{{ route('admin.users.show',$user) }}"
                                class="inline-flex rounded-xl bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">

                                View

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="py-10 text-center text-gray-500">

                            No users found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="border-t px-6 py-4">

            {{ $users->links() }}

        </div>

    </div>

</div>

</x-layouts.admin-layout>