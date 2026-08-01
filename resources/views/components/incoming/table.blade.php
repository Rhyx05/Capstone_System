<div class="bg-white rounded-xl shadow border overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>

                <th class="px-6 py-4 text-left">
                    Tracking Code
                </th>

                <th class="px-6 py-4 text-left">
                    Title
                </th>

                <th class="px-6 py-4 text-left">
                    Priority
                </th>

                <th class="px-6 py-4 text-left">
                    From Office
                </th>

                <th class="px-6 py-4 text-left">
                    Assigned Date
                </th>

                <th class="px-6 py-4 text-left">
                    Status
                </th>

                <th class="px-6 py-4 text-center">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>

        @forelse($documents as $document)

            <tr class="border-t hover:bg-gray-50">

                <td class="px-6 py-4 font-semibold">

                    {{ $document->tracking_code }}

                </td>

                <td class="px-6 py-4">

                    {{ $document->title }}

                </td>

                <td class="px-6 py-4">

                    @php

                        $priorityColors = [

                            'Urgent' => 'bg-red-100 text-red-700',

                            'High' => 'bg-orange-100 text-orange-700',

                            'Normal' => 'bg-blue-100 text-blue-700',

                        ];

                    @endphp

                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $priorityColors[$document->priority] ?? 'bg-gray-100 text-gray-700' }}">

                        {{ $document->priority }}

                    </span>

                </td>

                <td class="px-6 py-4">

                    {{ optional($document->office)->office_name }}

                </td>

                <td class="px-6 py-4">

                    {{ optional($document->assigned_at)?->format('M d, Y h:i A') }}

                </td>

                <td class="px-6 py-4">

                    @php

                        $colors = [

                            'assigned' => 'bg-blue-100 text-blue-700',

                            'completed' => 'bg-green-100 text-green-700',

                            'archived' => 'bg-purple-100 text-purple-700',

                            'approved' => 'bg-green-100 text-green-700',

                            'returned' => 'bg-yellow-100 text-yellow-700',

                            'rejected' => 'bg-red-100 text-red-700',

                        ];

                    @endphp

                    <span class="px-3 py-1 rounded-full text-sm {{ $colors[$document->status] ?? 'bg-gray-100 text-gray-700' }}">

                        {{ ucwords(str_replace('_',' ',$document->status)) }}

                    </span>

                </td>

                <td class="px-6 py-4 text-center">

<a
    href="{{ route('user.incoming.show', $document) }}"
    class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">

    View

</a>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="7">

                    <x-incoming.empty-state/>

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    @if($documents->count())

        <div class="border-t p-5">

            {{ $documents->links() }}

        </div>

    @endif

</div>