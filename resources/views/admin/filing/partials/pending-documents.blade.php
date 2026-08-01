<div class="bg-white rounded-2xl border shadow-sm">

    {{-- Header --}}
    <div class="border-b px-6 py-5">

        <h2 class="text-xl font-bold">
            Documents Ready for Filing
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Completed documents waiting to be archived into repositories.
        </p>

    </div>

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
                        Submitted By
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Approve & Completed By
                    </th>


                    <th class="px-6 py-4 text-center font-semibold">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($pendingDocuments as $document)

                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-6 py-4 font-medium text-blue-700">

                            {{ $document->tracking_code }}

                        </td>

                        <td class="px-6 py-4">

                            {{ $document->title }}

                        </td>

                        <td class="px-6 py-4">

                            {{ optional($document->office)->office_name }}

                        </td>

                        <td class="px-6 py-4">

    {{ optional($document->submittedBy)->full_name ?? 'Unknown User' }}

</td>

                        <td class="px-6 py-4">

                          {{ optional($document->approver)->full_name }}

                        </td>


                        <td class="px-6 py-4 text-center">

                            <div class="flex items-center justify-center gap-2">

                                {{-- View --}}
                                <a
                                    href="{{ route('admin.filing.show', $document) }}"
                                    class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-white font-medium transition hover:bg-indigo-700">

                                    👁 View

                                </a>

                                {{-- Delete --}}
                                <form
                                    action="{{ route('admin.filing.pending.destroy', $document) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to permanently delete this document? This action cannot be undone.')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center rounded-xl bg-red-600 px-4 py-2 text-white font-medium transition hover:bg-red-700">

                                        🗑 Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="py-12 text-center text-gray-500">

                            No documents waiting for filing.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="border-t px-6 py-4">

        {{ $pendingDocuments->links() }}

    </div>

</div>