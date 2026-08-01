<x-layouts.employee-layout>

<div class="space-y-8">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold text-gray-900">

            History Logs

        </h1>

        <p class="mt-2 text-gray-500">

            Track every action you've performed on documents.

        </p>

    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="rounded-2xl bg-white border shadow-sm p-6">

            <p class="text-sm text-gray-500">

                Submitted Documents

            </p>

            <h2 class="mt-3 text-4xl font-bold text-blue-600">

                {{ $submitted }}

            </h2>

        </div>

        <div class="rounded-2xl bg-white border shadow-sm p-6">

            <p class="text-sm text-gray-500">

                Processed

            </p>

            <h2 class="mt-3 text-4xl font-bold text-orange-500">

                {{ $processed }}

            </h2>

        </div>

        <div class="rounded-2xl bg-white border shadow-sm p-6">

            <p class="text-sm text-gray-500">

                Approved

            </p>

            <h2 class="mt-3 text-4xl font-bold text-green-600">

                {{ $approved }}

            </h2>

        </div>

        <div class="rounded-2xl bg-white border shadow-sm p-6">

            <p class="text-sm text-gray-500">

                Rejected

            </p>

            <h2 class="mt-3 text-4xl font-bold text-red-600">

                {{ $rejected }}

            </h2>

        </div>

    </div>

    {{-- Search --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6">

        <form method="GET">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search document..."
                    class="rounded-xl border-gray-300">

                <select
                    name="action"
                    class="rounded-xl border-gray-300">

                    <option value="">

                        All Actions

                    </option>

                    <option value="Submitted">

                        Submitted

                    </option>

                    <option value="Started Processing">

                        Started Processing

                    </option>

                    <option value="Forwarded">

                        Forwarded

                    </option>

                    <option value="Completed">

                        Completed

                    </option>

                    <option value="Rejected">

                        Rejected

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
{{-- HISTORY TABLE --}}
{{-- ========================================================= --}}

<div class="bg-white rounded-2xl shadow border">

    <div class="px-6 py-5 border-b">

        <h2 class="text-xl font-bold">
            Activity History
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            All actions you performed on documents.
        </p>

    </div>

    <div class="overflow-x-auto overflow-y-auto max-h-[600px]">

        <table class="min-w-full text-sm">

            <thead class="bg-gray-50 sticky top-0 z-10">

                <tr>

                    <th class="px-6 py-4 text-left font-semibold">
                        Tracking Code
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Document
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Action
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Remarks
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Date
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y">

                @forelse($logs as $log)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4 font-medium text-blue-700">
                            {{ $log->document->tracking_code }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $log->document->title }}
                        </td>

                        <td class="px-6 py-4">

                            <span class="px-3 py-1 rounded-full text-xs font-semibold

                                @switch($log->action)

                                    @case('Submitted')
                                    @case('Submitted for Approval')
                                        bg-blue-100 text-blue-700
                                        @break

                                    @case('Forwarded')
                                        bg-purple-100 text-purple-700
                                        @break

                                    @case('Completed')
                                        bg-green-100 text-green-700
                                        @break

                                    @case('Rejected')
                                        bg-red-100 text-red-700
                                        @break

                                    @default
                                        bg-gray-100 text-gray-700

                                @endswitch">

                                {{ $log->action }}

                            </span>

                        </td>

                        <td class="px-6 py-4">
                            {{ $log->remarks }}
                        </td>

                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            {{ $log->created_at->format('M d, Y h:i A') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">

                            No activity found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
</x-layouts.employee-layout>