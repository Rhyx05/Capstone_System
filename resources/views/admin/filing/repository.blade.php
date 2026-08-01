<x-layouts.admin-layout>

<div class="space-y-8">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div>

        <a
            href="{{ route('admin.filing.index') }}"
            class="text-blue-600 hover:text-blue-800 text-sm font-medium">

            ← Back to Electronic Filing

        </a>

        <h1 class="mt-3 text-3xl font-bold text-gray-900">

            {{ $category->name }} Repository

        </h1>

        <p class="mt-2 text-gray-500">

            {{ $category->description }}

        </p>

    </div>

    {{-- ========================================================= --}}
    {{-- ACTION BAR --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-2xl border shadow-sm p-5">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div class="flex gap-3">

                <input
                    type="text"
                    placeholder="Search documents..."
                    class="rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                <button
                    class="rounded-xl bg-blue-600 text-white px-5 py-2 hover:bg-blue-700">

                    Search

                </button>

            </div>

            <div>

                <span class="text-gray-500">

                    {{ $documents->total() }}

                    Archived Documents

                </span>

            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- DOCUMENT TABLE --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left font-semibold">

                            Tracking Code

                        </th>

                        <th class="px-6 py-4 text-left font-semibold">

                            Title

                        </th>

                        <th class="px-6 py-4 text-left font-semibold">

                            Office

                        </th>

                        <th class="px-6 py-4 text-left font-semibold">

                            Archived By

                        </th>

                        <th class="px-6 py-4 text-left font-semibold">

                            Archived Date

                        </th>

                        <th class="px-6 py-4 text-center font-semibold">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($documents as $document)

                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-6 py-4">

                            {{ $document->tracking_code }}

                        </td>

                        <td class="px-6 py-4">

                            {{ $document->title }}

                        </td>

                        <td class="px-6 py-4">

                            {{ optional($document->office)->office_name }}

                        </td>

                        <td class="px-6 py-4">

                          {{ optional($document->approver)->full_name }}

                        </td>

                        <td class="px-6 py-4">

                            {{ optional($document->updated_at)->format('M d, Y h:i A') }}

                        </td>

                        <td class="px-6 py-4 text-center">

                         <a
    href="{{ route('admin.filing.repository.document.show', $document) }}"
    class="inline-flex items-center rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2 text-white transition">

    👁 View

</a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="py-12 text-center text-gray-500">

                            No archived documents inside this repository.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="border-t px-6 py-4">

            {{ $documents->links() }}

        </div>

    </div>

</div>

</x-layouts.admin-layout>