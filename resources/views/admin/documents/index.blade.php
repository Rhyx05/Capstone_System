<x-layouts.admin-layout>

{{-- ========================================================= --}}
{{-- SUCCESS MESSAGE --}}
{{-- ========================================================= --}}

@if(session('success'))

<div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-6 py-4 flex items-center gap-3">

    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">

        ✅

    </div>

    <div>

        <p class="font-semibold text-green-800">

            Success

        </p>

        <p class="text-green-700">

            {{ session('success') }}

        </p>

    </div>

</div>

@endif

<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Incoming Documents
            </h1>

            <p class="mt-1 text-gray-500">
                Review employee submitted documents.
            </p>

        </div>

    </div>

    {{-- Success Message --}}
    @if(session('success'))

        <div class="rounded-lg border border-green-300 bg-green-100 p-4 text-green-700">

            {{ session('success') }}

        </div>

    @endif

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl bg-white shadow">

     {{-- Search & Filter --}}
<div class="border-b p-6">

    <form method="GET">

        <div class="flex flex-col gap-3 lg:flex-row lg:items-center">

            {{-- Search --}}
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search Tracking Code or Title..."
                class="flex-1 rounded-lg border-gray-300">

            {{-- Status --}}
            <select
                name="status"
                class="rounded-lg border-gray-300">

                <option value="">All Status</option>

                <option value="for_review"
                    {{ request('status') == 'for_review' ? 'selected' : '' }}>
                    For Review
                </option>

                <option value="approved"
                    {{ request('status') == 'approved' ? 'selected' : '' }}>
                    Approved
                </option>

                <option value="assigned"
                    {{ request('status') == 'assigned' ? 'selected' : '' }}>
                    Assigned
                </option>

                <option value="returned"
                    {{ request('status') == 'returned' ? 'selected' : '' }}>
                    Returned
                </option>

            </select>

            {{-- Priority --}}
            <select
                name="priority"
                class="rounded-lg border-gray-300">

                <option value="">All Priority</option>

                <option value="Urgent"
                    {{ request('priority') == 'Urgent' ? 'selected' : '' }}>
                    Urgent
                </option>

                <option value="High"
                    {{ request('priority') == 'High' ? 'selected' : '' }}>
                    High
                </option>

                <option value="Normal"
                    {{ request('priority') == 'Normal' ? 'selected' : '' }}>
                    Normal
                </option>

            </select>

            {{-- Sort --}}
            <select
                name="sort"
                class="rounded-lg border-gray-300">

                <option value="latest"
                    {{ request('sort') == 'latest' ? 'selected' : '' }}>
                    Latest First
                </option>

                <option value="oldest"
                    {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                    Oldest First
                </option>

                <option value="title"
                    {{ request('sort') == 'title' ? 'selected' : '' }}>
                    Title (A-Z)
                </option>

                <option value="priority"
                    {{ request('sort') == 'priority' ? 'selected' : '' }}>
                    Priority
                </option>

            </select>

            {{-- Search Button --}}
            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">

                Search

            </button>

            {{-- Reset --}}
            <a
                href="{{ route('admin.documents') }}"
                class="rounded-lg border border-gray-300 px-6 py-2 text-center hover:bg-gray-100">

                Reset

            </a>

        </div>

    </form>

</div>

      <div class="max-h-[650px] overflow-auto">

           <table class="min-w-full">

          <thead class="sticky top-0 z-10 bg-gray-100">

                    <tr>

                        <th class="p-4 text-left">Tracking</th>

                        <th class="p-4 text-left">Title</th>

                        <th class="p-4 text-left">Employee</th>

                        <th class="p-4 text-left">Office</th>

                        <th class="p-4 text-center">Priority</th>

                        <th class="p-4 text-center">Status</th>

                        <th class="p-4 text-center">Submitted</th>

                        <th class="p-4 text-center">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($documents as $document)

                    <tr class="border-t hover:bg-gray-50">

                        <td class="p-4 font-semibold text-blue-700">

                            {{ $document->tracking_code }}

                        </td>

                        <td class="p-4">

                            {{ $document->title }}

                        </td>

                        <td class="p-4">

                            {{ optional($document->submittedBy)->first_name }}
                            {{ optional($document->submittedBy)->last_name }}

                        </td>

                        <td class="p-4">

                            {{ optional($document->office)->office_name ?? '—' }}

                        </td>

                        <td class="p-4 text-center">

                            @php

                                $priorityColor = match($document->priority){

                                    'Urgent' => 'bg-red-100 text-red-700',

                                    'High' => 'bg-orange-100 text-orange-700',

                                    'Normal' => 'bg-blue-100 text-blue-700',

                                    default => 'bg-gray-100 text-gray-700'

                                };

                            @endphp

                            <span class="rounded-full px-3 py-1 text-sm {{ $priorityColor }}">

                                {{ $document->priority }}

                            </span>

                        </td>

                        <td class="p-4 text-center">

                            @php

                                $statusColor = match($document->status){

                                    'for_review' => 'bg-yellow-100 text-yellow-700',

                                    'approved' => 'bg-green-100 text-green-700',

                                    'returned' => 'bg-orange-100 text-orange-700',
                                    
                                    default => 'bg-gray-100 text-gray-700'

                                };

                            @endphp

                            <span class="rounded-full px-3 py-1 text-sm {{ $statusColor }}">

                                {{ ucwords(str_replace('_',' ',$document->status)) }}

                            </span>

                        </td>

                        <td class="p-4 text-center">

                            {{ optional($document->submission_date)?->format('M d, Y') ?? '—' }}

                        </td>

                        <td class="p-4 text-center">
                        <a
                            
                                href="{{ route('admin.documents.show', $document) }}"
                                class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">

                                Review

                            </>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="p-10 text-center text-gray-500">

                           No documents waiting for review.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="border-t p-5">

            {{ $documents->links() }}

        </div>

    </div>

</div>

</x-layouts.admin-layout>