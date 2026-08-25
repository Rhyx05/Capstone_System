<x-layouts.admin-layout>

<div class="max-w-6xl mx-auto">

@if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
        <span class="text-lg">✅</span>
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
@endif

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Announcements</h1>
                        <p class="mt-0.5 text-sm text-gray-500">Create and manage announcements for all employees.</p>
                    </div>
                </div>

                <a
                    href="{{ route('admin.announcements.create') }}"
                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                    + New Announcement
                </a>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Table --}}
        @if($announcements->count())

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3.5 text-left">Title</th>
                            <th class="px-6 py-3.5 text-center">Status</th>
                            <th class="px-6 py-3.5 text-center">Pinned</th>
                            <th class="px-6 py-3.5 text-center">Posted By</th>
                            <th class="px-6 py-3.5 text-center">Date</th>
                            <th class="px-6 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($announcements as $announcement)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ $announcement->title }}
                                    </div>
                                    <div class="mt-0.5 text-xs text-gray-500">
                                        {{ \Illuminate\Support\Str::limit($announcement->content, 100) }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($announcement->is_published)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border bg-green-50 text-green-700 border-green-200">
                                            Published
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border bg-gray-100 text-gray-600 border-gray-200">
                                            Draft
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($announcement->is_pinned)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border bg-amber-50 text-amber-600 border-amber-200">
                                            📌 Pinned
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center text-gray-600">
                                    {{ optional($announcement->author)->full_name }}
                                </td>

                                <td class="px-6 py-4 text-center text-gray-500 text-xs">
                                    {{ optional($announcement->published_at)->format('M d, Y h:i A') }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">

                                        <button
                                            type="button"
                                            onclick="openEditModal(
                                                '{{ $announcement->id }}',
                                                '{{ addslashes($announcement->title) }}',
                                                '{{ addslashes($announcement->content) }}',
                                                {{ $announcement->is_pinned ? 'true' : 'false' }},
                                                {{ $announcement->is_published ? 'true' : 'false' }}
                                            )"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition">
                                            ✏ Edit
                                        </button>

                                        <button
                                            type="button"
                                            onclick="openDeleteModal(
                                                '{{ $announcement->id }}',
                                                '{{ addslashes($announcement->title) }}'
                                            )"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-xl transition">
                                            🗑 Delete
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

            @if($announcements->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $announcements->links() }}
                </div>
            @endif

        @else

            {{-- Empty State --}}
            <div class="px-8 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 border border-gray-200 text-2xl mb-4">
                    📢
                </div>
                <h2 class="text-base font-semibold text-gray-900">No Announcements Yet</h2>
                <p class="text-sm text-gray-500 mt-1">Post your first announcement to keep employees informed.</p>
            </div>

        @endif

    </div>

</div>

{{-- ===================================================== --}}
{{-- EDIT MODAL --}}
{{-- ===================================================== --}}
<div id="editAnnouncementModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-lg font-bold text-gray-900">✏ Edit Announcement</h2>
            <p class="mt-1 text-sm text-gray-500">Update the details of this announcement.</p>
        </div>

        <div class="border-t border-gray-100"></div>

        <form id="editAnnouncementForm" method="POST">
            @csrf
            @method('PUT')

            <div class="px-8 py-6 space-y-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                    <input
                        type="text"
                        name="title"
                        id="editTitle"
                        required
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Content</label>
                    <textarea
                        name="content"
                        id="editContent"
                        rows="5"
                        required
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>

                <div class="flex flex-wrap gap-6">

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_pinned" id="editPinned" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700">📌 Pin this announcement</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" id="editPublished" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700">Publish immediately</span>
                    </label>

                </div>

            </div>

            <div class="border-t border-gray-100"></div>

            <div class="flex justify-end gap-3 px-8 py-5">
                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="rounded-xl bg-indigo-600 hover:bg-indigo-700 px-6 py-2.5 text-sm font-semibold text-white transition">
                    Save Changes
                </button>
            </div>

        </form>

    </div>

</div>

{{-- ===================================================== --}}
{{-- DELETE MODAL --}}
{{-- ===================================================== --}}
<div id="deleteAnnouncementModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-lg font-bold text-red-600">🗑 Delete Announcement</h2>
            <p class="mt-2 text-sm text-gray-500">
                Are you sure you want to delete
                <span id="deleteAnnouncementTitle" class="font-semibold text-gray-800"></span>?
                This action cannot be undone.
            </p>
        </div>

        <div class="border-t border-gray-100"></div>

        <form id="deleteAnnouncementForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex justify-end gap-3 px-8 py-5">
                <button
                    type="button"
                    onclick="closeDeleteModal()"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="rounded-xl bg-red-600 hover:bg-red-700 px-6 py-2.5 text-sm font-semibold text-white transition">
                    Delete
                </button>
            </div>

        </form>

    </div>

</div>

<script>
function showModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function hideModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

function openEditModal(id, title, content, isPinned, isPublished) {
    document.getElementById('editAnnouncementForm').action = '/admin/announcements/' + id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editContent').value = content;
    document.getElementById('editPinned').checked = isPinned;
    document.getElementById('editPublished').checked = isPublished;
    showModal('editAnnouncementModal');
}

function closeEditModal() {
    hideModal('editAnnouncementModal');
}

function openDeleteModal(id, title) {
    document.getElementById('deleteAnnouncementForm').action = '/admin/announcements/' + id;
    document.getElementById('deleteAnnouncementTitle').textContent = title;
    showModal('deleteAnnouncementModal');
}

function closeDeleteModal() {
    hideModal('deleteAnnouncementModal');
}
</script>

</x-layouts.admin-layout>