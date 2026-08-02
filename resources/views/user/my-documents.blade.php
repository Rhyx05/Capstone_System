<x-layouts.employee-layout>

<div class="max-w-6xl mx-auto">

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">My Documents</h1>
                    <p class="mt-0.5 text-sm text-gray-500">View and track all documents you have submitted.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Statistics --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 p-6">

            <div class="flex items-center gap-4 rounded-xl border border-gray-300 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 text-lg">📤</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Submitted</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $submittedCount }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-300 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 text-lg">⏳</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">For Review</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $reviewCount }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-300 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600 text-lg">✅</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Approved</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $approvedCount }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-300 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600 text-lg">↩️</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Returned / Rejected</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $returnedCount }}</h2>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Filters: search title + status only — auto-filters the table live --}}
        <form method="GET" action="{{ route('user.documents') }}" id="filterForm" class="px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center gap-3">

                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    value="{{ request('search') }}"
                    placeholder="Search title or tracking code..."
                    autocomplete="off"
                    class="flex-1 rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                <select name="status" id="statusSelect" class="rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-52">
                    <option value="">All Status</option>
                    <option value="for_review" @selected(request('status')=='for_review')>For Review</option>
                    <option value="approved" @selected(request('status')=='approved')>Approved</option>
                    <option value="assigned" @selected(request('status')=='assigned')>Assigned</option>
                    <option value="returned" @selected(request('status')=='returned')>Returned</option>
                    <option value="rejected" @selected(request('status')=='rejected')>Rejected</option>
                    <option value="completed" @selected(request('status')=='completed')>Completed</option>
                </select>

            </div>
        </form>

        <div class="border-t border-gray-100"></div>

        {{-- Table --}}
        @if($documents->count())

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3.5 text-left">Tracking Code</th>
                            <th class="px-6 py-3.5 text-left">Title</th>
                            <th class="px-6 py-3.5 text-left">Category</th>
                            <th class="px-6 py-3.5 text-left">Priority</th>
                            <th class="px-6 py-3.5 text-left">Status</th>
                            <th class="px-6 py-3.5 text-left">Submitted</th>
                            <th class="px-6 py-3.5 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @php
                            $statusColors = [
                                'for_review' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'approved'   => 'bg-green-50 text-green-700 border-green-200',
                                'assigned'   => 'bg-blue-50 text-blue-700 border-blue-200',
                                'returned'   => 'bg-orange-50 text-orange-700 border-orange-200',
                                'rejected'   => 'bg-red-50 text-red-700 border-red-200',
                                'completed'  => 'bg-gray-100 text-gray-700 border-gray-200',
                            ];
                            $priorityColors = [
                                'Low'    => 'bg-green-500',
                                'Normal' => 'bg-blue-500',
                                'High'   => 'bg-orange-500',
                                'Urgent' => 'bg-red-500',
                            ];
                        @endphp

                        @foreach($documents as $document)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $document->tracking_code }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $document->title }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $document->category }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 font-medium text-gray-700">
                                        <span class="h-2 w-2 rounded-full {{ $priorityColors[$document->priority] ?? 'bg-gray-400' }}"></span>
                                        {{ $document->priority }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$document->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        {{ ucwords(str_replace('_', ' ', $document->status)) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-500 text-xs">
                                    {{ $document->submission_date->format('M d, Y h:i A') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a
                                        href="{{ route('user.documents.show', $document) }}"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition">
                                        👁 View
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

            @if($documents->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $documents->appends(request()->query())->links() }}
                </div>
            @endif

        @else

            {{-- Empty State --}}
            <div class="px-8 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 border border-gray-200 text-2xl mb-4">
                    📄
                </div>
                <h2 class="text-base font-semibold text-gray-900">No Documents Found</h2>
                <p class="text-sm text-gray-500 mt-1">
                    @if(request('search') || request('status'))
                        No documents match your search or filter.
                    @else
                        You haven't submitted any documents yet.
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
    const statusSelect = document.getElementById('statusSelect');
    let debounceTimer;

    // Live filter as the user types (debounced so it doesn't submit on every keystroke)
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            form.submit();
        }, 500);
    });

    // Instant filter when the status dropdown changes
    statusSelect.addEventListener('change', function () {
        form.submit();
    });
})();
</script>

</x-layouts.employee-layout>