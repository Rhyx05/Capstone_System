<div class="max-w-6xl mx-auto space-y-6">

    {{-- ================= Single Unified Card: Header + Statistics + Repositories ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Electronic Filing</h1>
                        <p class="mt-0.5 text-sm text-gray-500">Manage repositories and archived documents.</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Statistics --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 p-6">

            <div class="flex items-center gap-4 rounded-xl border border-gray-400 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 text-lg">📂</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Repositories</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $totalRepositories }}</h2>
                    <p class="text-xs text-gray-400">Filing Categories</p>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-400 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600 text-lg">📄</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Archived Documents</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $archivedDocuments }}</h2>
                    <p class="text-xs text-gray-400">Total Archived Files</p>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-400 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 text-lg">📅</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Today's Archives</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $todayArchives }}</h2>
                    <p class="text-xs text-gray-400">Archived Today</p>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-400 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 text-lg">💾</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Storage Used</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ number_format($storageUsed / 1024 / 1024, 2) }} MB</h2>
                    <p class="text-xs text-gray-400">Archived Documents</p>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-400"></div>

        {{-- Repositories --}}
        <div class="px-8 py-6">

            <div class="flex items-center justify-between mb-5">

                {{-- Left: Title --}}
                <div class="flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">
                        🗂️
                    </span>
                    <h2 class="text-base font-semibold text-gray-900">
                        Repositories
                    </h2>
                </div>

                {{-- Right: Button --}}
                <button
                    type="button"
                    onclick="openCreateCategoryModal()"
                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                    + New Repository
                </button>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">

@forelse($repositories as $category)

<div
    onclick="window.location='{{ route('admin.filing.repository', $category) }}'"
    class="relative cursor-pointer bg-white border border-gray-200 rounded-xl p-4 hover:border-indigo-300 hover:shadow-lg transition duration-200">

    {{-- Three Dot Menu --}}
    <div class="absolute top-3 right-3">

        <button
            type="button"
            onclick="event.stopPropagation(); toggleMenu({{ $category->id }})"
            class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500">
            ⋮
        </button>

        <div
            id="menu-{{ $category->id }}"
            class="hidden absolute right-0 top-10 w-48 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden z-50">

<button
    type="button"
    onclick="event.stopPropagation(); toggleMenu({{ $category->id }}); openEditCategoryModal(
        {{ $category->id }},
        @js($category->name),
        @js($category->description ?? ''),
        @js($category->icon),
        @js($category->color)
    )"
    class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
    ✏ Edit Repository
</button>

<button
    type="button"
    onclick="event.stopPropagation();
        openDeleteRepositoryModal(
            {{ $category->id }},
            @js($category->name)
        )"
    class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">
    🗑 Delete Repository
</button>
        </div>

    </div>

    {{-- Repository Icon --}}
@php
$colors = [
    'indigo' => 'bg-indigo-50 text-indigo-600',
    'blue'   => 'bg-blue-50 text-blue-600',
    'green'  => 'bg-green-50 text-green-600',
    'yellow' => 'bg-yellow-50 text-yellow-600',
    'red'    => 'bg-red-50 text-red-600',
    'purple' => 'bg-purple-50 text-purple-600',
    'orange' => 'bg-orange-50 text-orange-600',
];
@endphp

<div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-3
{{ $colors[$category->color] ?? 'bg-indigo-50 text-indigo-600' }}">

    {{ $category->icon }}

</div>

    {{-- Repository Name --}}
    <h3 class="text-sm font-semibold text-gray-900 truncate">
        {{ $category->name }}
    </h3>

    {{-- Description --}}
    <p class="mt-1 text-xs text-gray-500 line-clamp-2 h-9">
        {{ $category->description ?: 'No description available.' }}
    </p>

    {{-- Bottom --}}
    <div class="mt-4">
        @php
$badgeColors = [
    'indigo' => 'bg-indigo-50 text-indigo-700',
    'blue'   => 'bg-blue-50 text-blue-700',
    'green'  => 'bg-green-50 text-green-700',
    'yellow' => 'bg-yellow-50 text-yellow-700',
    'red'    => 'bg-red-50 text-red-700',
    'purple' => 'bg-purple-50 text-purple-700',
    'orange' => 'bg-orange-50 text-orange-700',
];
@endphp

<span class="text-xs px-2.5 py-1 rounded-full font-medium
{{ $badgeColors[$category->color] ?? 'bg-indigo-50 text-indigo-700' }}">
            {{ $category->documents_count }}
            {{ Str::plural('Document', $category->documents_count) }}
        </span>
    </div>

</div>

@empty

<div class="col-span-full py-20 text-center">

    <div class="mx-auto w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-3xl">
        📂
    </div>

    <h2 class="mt-4 text-lg font-semibold text-gray-900">
        No Repositories Found
    </h2>

    <p class="mt-2 text-sm text-gray-500">
        Create your first repository to organize archived documents.
    </p>

</div>

@endforelse

            </div>

        </div>

    </div>
    {{-- ============ End of Header + Statistics + Repositories card ============ --}}

    {{-- ================= Separate Card: Documents Ready for Filing ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-base font-semibold text-gray-900">Documents Ready for Filing</h2>
            <p class="text-sm text-gray-500 mt-1">Completed documents waiting to be archived into repositories.</p>
        </div>

        <div class="border-t border-gray-100"></div>

        @if($pendingDocuments->count())

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3.5 text-left">Tracking Code</th>
                            <th class="px-6 py-3.5 text-left">Title</th>
                            <th class="px-6 py-3.5 text-left">Office</th>
                            <th class="px-6 py-3.5 text-left">Submitted By</th>
                            <th class="px-6 py-3.5 text-left">Approved & Completed By</th>
                            <th class="px-6 py-3.5 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($pendingDocuments as $document)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-semibold text-indigo-700">
                                    {{ $document->tracking_code }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $document->title }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ optional($document->office)->office_name }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ optional($document->submittedBy)->full_name ?? 'Unknown User' }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ optional($document->approver)->full_name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">

                                        <a
                                            href="{{ route('admin.filing.show', $document) }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition">
                                            👁 View
                                        </a>

                                        <form
                                            action="{{ route('admin.filing.pending.destroy', $document) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to permanently delete this document? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-xl transition">
                                                🗑 Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

            @if($pendingDocuments->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $pendingDocuments->links() }}
                </div>
            @endif

        @else

            <div class="px-8 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 border border-gray-200 text-2xl mb-4">
                    📁
                </div>
                <h2 class="text-base font-semibold text-gray-900">No Documents Waiting for Filing</h2>
                <p class="text-sm text-gray-500 mt-1">Completed documents will appear here once ready to archive.</p>
            </div>

        @endif

    </div>
    {{-- ============ End of Documents Ready for Filing card ============ --}}

</div>
<script>
function toggleMenu(id) {

    document.querySelectorAll("[id^='menu-']").forEach(menu => {
        if (menu.id !== "menu-" + id) {
            menu.classList.add("hidden");
        }
    });

    document.getElementById("menu-" + id).classList.toggle("hidden");
}

document.addEventListener("click", function () {
    document.querySelectorAll("[id^='menu-']").forEach(menu => {
        menu.classList.add("hidden");
    });
});

// Prevent clicks inside menus from closing them
document.querySelectorAll("[id^='menu-']").forEach(menu => {
    menu.addEventListener("click", function(e){
        e.stopPropagation();
    });
});
</script>