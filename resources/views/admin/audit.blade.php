<x-layouts.admin-layout>

<div class="max-w-6xl mx-auto">

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Audit Trail</h1>
                    <p class="mt-0.5 text-sm text-gray-500">Monitor every important activity performed throughout the system.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Filters: search + action + date — auto-filters the table live --}}
        <form method="GET" action="{{ route('admin.audit') }}" id="filterForm" class="px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center gap-3">

                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    value="{{ request('search') }}"
                    placeholder="Search user, action or description..."
                    autocomplete="off"
                    class="flex-1 rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                <select name="action" id="actionSelect" class="rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-56">
                    <option value="">All Actions</option>
                    @foreach([
                        'Submitted',
                        'Approved',
                        'Approved & Routed',
                        'Forwarded',
                        'Returned',
                        'Rejected',
                        'Started Processing',
                        'Completed'
                    ] as $action)
                        <option value="{{ $action }}" @selected(request('action') == $action)>
                            {{ $action }}
                        </option>
                    @endforeach
                </select>

                <input
                    type="date"
                    name="date"
                    id="dateInput"
                    value="{{ request('date') }}"
                    class="rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-48">

            </div>
        </form>

        <div class="border-t border-gray-100"></div>

        {{-- Table --}}
        @if($documents->count())

            <div class="px-6 pt-5 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-900">Audit Logs</h2>
                <span class="text-xs text-gray-500">{{ number_format($documents->total()) }} total</span>
            </div>

            <div class="overflow-x-auto mt-3">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3.5 text-left">Date</th>
                            <th class="px-6 py-3.5 text-left">Submitted By (User A)</th>
                            <th class="px-6 py-3.5 text-left">Admin Review</th>
                            <th class="px-6 py-3.5 text-left">User B</th>
                            <th class="px-6 py-3.5 text-left">User C (Secondary Approval)</th>
                            <th class="px-6 py-3.5 text-left">User D (Tertiary Approval)</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($documents as $document)

                            @php
                                // Admin's review action: Approved, Approved & Routed, Returned, or Rejected
                                $adminReview = $document->logs->first(function ($log) {
                                    return in_array(strtolower($log->action), [
                                        'approved',
                                        'approved & routed',
                                        'returned',
                                        'rejected',
                                    ]);
                                });

                                // Chain of processing actions after admin routes the document,
                                // in chronological order: 1st = User B, 2nd = User C, 3rd = User D
                                $processingLogs = $document->logs
                                    ->filter(function ($log) {
                                        return in_array(strtolower($log->action), [
                                            'started processing',
                                            'forwarded',
                                            'completed',
                                            'rejected',
                                        ]);
                                    })
                                    ->sortBy('created_at')
                                    ->values();

                                $userB = $processingLogs->get(0);
                                $userC = $processingLogs->get(1);
                                $userD = $processingLogs->get(2);

                                $actionColors = [
                                    'submitted'           => 'text-blue-600',
                                    'approved'            => 'text-green-600',
                                    'approved & routed'   => 'text-green-600',
                                    'forwarded'           => 'text-purple-600',
                                    'returned'            => 'text-orange-600',
                                    'rejected'            => 'text-red-600',
                                    'started processing'  => 'text-yellow-600',
                                    'completed'           => 'text-emerald-600',
                                ];
                            @endphp

                            <tr class="hover:bg-gray-50 transition">

                                {{-- DATE --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ $document->submission_date->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $document->submission_date->format('h:i A') }}
                                    </div>
                                </td>

                                {{-- SUBMITTED BY (User A) --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ $document->submittedBy->full_name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ optional($document->submittedBy->office)->office_name }}
                                    </div>
                                </td>

                                {{-- ADMIN REVIEW --}}
                                <td class="px-6 py-4">
                                    @if($adminReview)
                                        <div class="text-sm font-semibold text-gray-800">
                                            {{ optional($adminReview->user)->full_name }}
                                        </div>
                                        <div class="text-xs font-medium {{ $actionColors[strtolower($adminReview->action)] ?? 'text-gray-500' }}">
                                            {{ $adminReview->action }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- USER B --}}
                                <td class="px-6 py-4">
                                    @if($userB)
                                        <div class="text-sm font-semibold text-gray-800">
                                            {{ optional($userB->user)->full_name }}
                                        </div>
                                        <div class="text-xs font-medium {{ $actionColors[strtolower($userB->action)] ?? 'text-gray-500' }}">
                                            {{ $userB->action }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- USER C --}}
                                <td class="px-6 py-4">
                                    @if($userC)
                                        <div class="text-sm font-semibold text-gray-800">
                                            {{ optional($userC->user)->full_name }}
                                        </div>
                                        <div class="text-xs font-medium {{ $actionColors[strtolower($userC->action)] ?? 'text-gray-500' }}">
                                            {{ $userC->action }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- USER D --}}
                                <td class="px-6 py-4">
                                    @if($userD)
                                        <div class="text-sm font-semibold text-gray-800">
                                            {{ optional($userD->user)->full_name }}
                                        </div>
                                        <div class="text-xs font-medium {{ $actionColors[strtolower($userD->action)] ?? 'text-gray-500' }}">
                                            {{ $userD->action }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

            <div class="border-t border-gray-100 px-6 py-4">
                {{ $documents->appends(request()->query())->links() }}
            </div>

        @else

            {{-- Empty State --}}
            <div class="px-8 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 border border-gray-200 text-2xl mb-4">
                    🗂️
                </div>
                <h2 class="text-base font-semibold text-gray-900">No Documents Found</h2>
                <p class="text-sm text-gray-500 mt-1">
                    @if(request('search') || request('action') || request('date'))
                        No activity matches your search or filter.
                    @else
                        No audit activity has been recorded yet.
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
    const dateInput = document.getElementById('dateInput');
    let debounceTimer;

    // Live filter as the user types (debounced so it doesn't submit on every keystroke)
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            form.submit();
        }, 500);
    });

    // Instant filter when action or date changes
    actionSelect.addEventListener('change', function () {
        form.submit();
    });

    dateInput.addEventListener('change', function () {
        form.submit();
    });
})();
</script>

</x-layouts.admin-layout>