<x-layouts.employee-layout>
<div>

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-900">
            Received Documents
        </h1>

        <p class="mt-2 text-gray-500">
            Documents forwarded directly to you by the Administrator.
        </p>

    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-6 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Count --}}
    <div class="bg-white rounded-xl shadow border p-6 mb-6 inline-block">
        <p class="text-sm text-gray-500 uppercase">Total Received</p>
        <p class="text-2xl font-bold text-blue-700">{{ $receivedCount }}</p>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-xl shadow border p-6 mb-6">
        <form method="GET">
            <div class="flex gap-3">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by title or tracking code..."
                    class="flex-1 rounded-lg border-gray-300">

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-lg">
                    Search
                </button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow border">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-left">Tracking</th>
                        <th class="p-4 text-left">Title</th>
                        <th class="p-4 text-left">Sent By</th>
                        <th class="p-4 text-center">Priority</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Date Received</th>
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
                            {{ $document->submittedBy->first_name ?? '' }} {{ $document->submittedBy->last_name ?? '' }}
                        </td>

                        <td class="p-4 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @switch($document->priority)
                                    @case('Urgent')
                                        bg-red-100 text-red-700
                                        @break

                                    @case('High')
                                        bg-orange-100 text-orange-700
                                        @break

                                    @case('Normal')
                                        bg-blue-100 text-blue-700
                                        @break

                                    @default
                                        bg-gray-100 text-gray-700
                                @endswitch">
                                {{ $document->priority }}
                            </span>
                        </td>

                        <td class="p-4 text-center">
                            <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                                {{ ucwords(str_replace('_', ' ', $document->status)) }}
                            </span>
                        </td>

                        <td class="p-4 text-center">
                            {{ $document->submission_date->format('M d, Y') }}
                        </td>

                        <td class="p-4 text-center">
                            
                                href="{{ route('user.documents.show', $document) }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                                View
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="p-10 text-center text-gray-500">
                            No documents received yet.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-5 border-t">
            {{ $documents->links() }}
        </div>

    </div>

</div>
</x-layouts.employee-layout>