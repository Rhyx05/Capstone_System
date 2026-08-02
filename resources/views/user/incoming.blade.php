<x-layouts.employee-layout>

<div class="max-w-6xl mx-auto">

    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}
    @if(session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-6 py-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                ✅
            </div>
            <div>
                <p class="font-semibold text-green-800">Success</p>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Incoming Documents</h1>
                    <p class="mt-0.5 text-sm text-gray-500">Documents assigned to you by the Administrator.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Filters: search + priority — auto-filters the table live --}}
        <form method="GET" action="{{ route('user.incoming') }}" id="filterForm" class="px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center gap-3">

                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    value="{{ request('search') }}"
                    placeholder="Search title or tracking code..."
                    autocomplete="off"
                    class="flex-1 rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                <select name="priority" id="prioritySelect" class="rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-52">
                    <option value="">All Priorities</option>
                    <option value="Urgent" @selected(request('priority')=='Urgent')>Urgent</option>
                    <option value="High" @selected(request('priority')=='High')>High</option>
                    <option value="Normal" @selected(request('priority')=='Normal')>Normal</option>
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
                            <th class="px-6 py-3.5 text-left">Priority</th>
                            <th class="px-6 py-3.5 text-left">From Office</th>
                            <th class="px-6 py-3.5 text-left">Assigned Date</th>
                            <th class="px-6 py-3.5 text-left">Status</th>
                            <th class="px-6 py-3.5 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @php
                            $priorityColors = [
                                'Urgent' => 'bg-red-500',
                                'High'   => 'bg-orange-500',
                                'Normal' => 'bg-blue-500',
                            ];
                            $statusColors = [
                                'assigned'  => 'bg-blue-50 text-blue-700 border-blue-200',
                                'completed' => 'bg-gray-100 text-gray-700 border-gray-200',
                                'archived'  => 'bg-purple-50 text-purple-700 border-purple-200',
                                'approved'  => 'bg-green-50 text-green-700 border-green-200',
                                'returned'  => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'rejected'  => 'bg-red-50 text-red-700 border-red-200',
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

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 font-medium text-gray-700">
                                        <span class="h-2 w-2 rounded-full {{ $priorityColors[$document->priority] ?? 'bg-gray-400' }}"></span>
                                        {{ $document->priority }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ optional($document->office)->office_name }}
                                </td>

                                <td class="px-6 py-4 text-gray-500 text-xs">
                                    {{ optional($document->assigned_at)?->format('M d, Y h:i A') }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$document->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        {{ ucwords(str_replace('_', ' ', $document->status)) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a
                                        href="{{ route('user.incoming.show', $document) }}"
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
                    📥
                </div>
                <h2 class="text-base font-semibold text-gray-900">No Incoming Documents</h2>
                <p class="text-sm text-gray-500 mt-1">
                    @if(request('search') || request('priority'))
                        No documents match your search or filter.
                    @else
                        You have no documents assigned to you yet.
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
    const prioritySelect = document.getElementById('prioritySelect');
    let debounceTimer;

    // Live filter as the user types (debounced so it doesn't submit on every keystroke)
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            form.submit();
        }, 500);
    });

    // Instant filter when the priority dropdown changes
    prioritySelect.addEventListener('change', function () {
        form.submit();
    });
})();
</script>

</x-layouts.employee-layout>