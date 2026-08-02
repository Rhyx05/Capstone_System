<x-layouts.employee-layout>

<div class="max-w-6xl mx-auto">

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">History Logs</h1>
                    <p class="mt-0.5 text-sm text-gray-500">Track every action you've performed on documents.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Filters: search + action — auto-filters the table live --}}
        <form method="GET" action="{{ url()->current() }}" id="filterForm" class="px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center gap-3">

                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    value="{{ request('search') }}"
                    placeholder="Search document title or tracking code..."
                    autocomplete="off"
                    class="flex-1 rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                <select name="action" id="actionSelect" class="rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-56">
                    <option value="">All Actions</option>
                    <option value="Submitted" @selected(request('action')=='Submitted')>Submitted</option>
                    <option value="Forwarded" @selected(request('action')=='Forwarded')>Forwarded</option>
                    <option value="Completed" @selected(request('action')=='Completed')>Completed</option>
                    <option value="Rejected" @selected(request('action')=='Rejected')>Rejected</option>
                </select>

            </div>
        </form>

        <div class="border-t border-gray-100"></div>

        {{-- Table --}}
        @if($logs->count())

            <div class="overflow-x-auto overflow-y-auto max-h-[600px]">
                <table class="w-full text-sm">

                    <thead class="sticky top-0 z-10">
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3.5 text-left">Tracking Code</th>
                            <th class="px-6 py-3.5 text-left">Document</th>
                            <th class="px-6 py-3.5 text-left">Action</th>
                            <th class="px-6 py-3.5 text-left">Remarks</th>
                            <th class="px-6 py-3.5 text-left">Date</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @php
                            $actionColors = [
                                'Submitted'              => 'bg-blue-50 text-blue-700 border-blue-200',
                                'Submitted for Approval'  => 'bg-blue-50 text-blue-700 border-blue-200',
                                'Started Processing'     => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'Forwarded'               => 'bg-purple-50 text-purple-700 border-purple-200',
                                'Completed'               => 'bg-green-50 text-green-700 border-green-200',
                                'Rejected'                => 'bg-red-50 text-red-700 border-red-200',
                            ];
                        @endphp

                        @foreach($logs as $log)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-semibold text-indigo-700">
                                    {{ $log->document->tracking_code }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $log->document->title }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $actionColors[$log->action] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        {{ $log->action }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $log->remarks }}
                                </td>

                                <td class="px-6 py-4 text-gray-500 text-xs whitespace-nowrap">
                                    {{ $log->created_at->format('M d, Y h:i A') }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

            @if($logs->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            @endif

        @else

            {{-- Empty State --}}
            <div class="px-8 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 border border-gray-200 text-2xl mb-4">
                    🕓
                </div>
                <h2 class="text-base font-semibold text-gray-900">No Activity Found</h2>
                <p class="text-sm text-gray-500 mt-1">
                    @if(request('search') || request('action'))
                        No activity matches your search or filter.
                    @else
                        You haven't performed any document actions yet.
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
    const actionSelect = document.getElementById('actionSelect');
    let debounceTimer;

    // Live filter as the user types (debounced so it doesn't submit on every keystroke)
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            form.submit();
        }, 500);
    });

    // Instant filter when the action dropdown changes
    actionSelect.addEventListener('change', function () {
        form.submit();
    });
})();
</script>

</x-layouts.employee-layout>