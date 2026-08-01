<div class="bg-white rounded-xl shadow border overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>

                <th class="px-6 py-4 text-left">Tracking Code</th>

                <th class="px-6 py-4 text-left">Title</th>

                <th class="px-6 py-4 text-left">Category</th>

                <th class="px-6 py-4 text-left">Priority</th>

                <th class="px-6 py-4 text-left">Status</th>

                <th class="px-6 py-4 text-left">Submitted</th>

                <th class="px-6 py-4 text-center">Action</th>

            </tr>

        </thead>

        <tbody>

            @forelse($documents as $document)

                @php

                    $colors = [

                        'for_review' => 'bg-yellow-100 text-yellow-700',

                        'approved' => 'bg-green-100 text-green-700',

                        'returned' => 'bg-red-100 text-red-700',

                        'received' => 'bg-blue-100 text-blue-700',

                        'archived' => 'bg-gray-200 text-gray-700',

                    ];

                @endphp

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-6 py-4 font-semibold">

                        {{ $document->tracking_code }}

                    </td>

                    <td class="px-6 py-4">

                        {{ $document->title }}

                    </td>

                    <td class="px-6 py-4">

                        {{ $document->category }}

                    </td>

                    <td class="px-6 py-4">

                        <span class="font-medium">

                            {{ $document->priority }}

                        </span>

                    </td>

                    <td class="px-6 py-4">

                        <span class="px-3 py-1 rounded-full text-sm {{ $colors[$document->status] ?? 'bg-gray-100 text-gray-700' }}">

                            {{ ucwords(str_replace('_', ' ', $document->status)) }}

                        </span>

                    </td>

                    <td class="px-6 py-4">

                        {{ $document->submission_date->format('M d, Y h:i A') }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        <a
                            href="{{ route('user.documents.show', $document) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">

                            👁 View

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7">

                        <x-documents.empty-state />

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    @if($documents->hasPages())

        <div class="border-t p-5">

            {{ $documents->links() }}

        </div>

    @endif

</div>