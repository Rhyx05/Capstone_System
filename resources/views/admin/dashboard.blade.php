<x-layouts.admin-layout>

<div class="max-w-5xl mx-auto">

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Administrator Dashboard</h1>
                    <p class="mt-0.5 text-sm text-gray-500">Latest announcements posted by the administration.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Section title --}}
        <div class="flex items-center gap-2 px-8 py-5">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-sm">📢</span>
            <h2 class="text-base font-semibold text-gray-900">Announcements</h2>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Announcements list --}}
        <div class="divide-y divide-gray-100">

            @forelse($announcements as $announcement)

                <div class="px-8 py-6">

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex items-center gap-2">
                            @if($announcement->is_pinned)
                                <span class="flex items-center gap-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold px-2.5 py-1 border border-amber-200">
                                    📌 Pinned
                                </span>
                            @endif
                            <h3 class="text-base font-semibold text-gray-900">
                                {{ $announcement->title }}
                            </h3>
                        </div>

                        <span class="shrink-0 text-xs font-medium text-gray-500 bg-gray-50 rounded-full px-3 py-1 border border-gray-200">
                            {{ optional($announcement->published_at)->format('M d, Y h:i A') }}
                        </span>

                    </div>

                    <div class="mt-3 whitespace-pre-line text-sm text-gray-600 leading-7">
                        {{ $announcement->content }}
                    </div>

                    <div class="mt-4 flex items-center gap-2 text-xs text-gray-500">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 font-semibold text-[10px]">
                            {{ strtoupper(substr(optional($announcement->author)->full_name, 0, 1)) }}
                        </span>
                        Posted by
                        <span class="font-semibold text-gray-700">
                            {{ optional($announcement->author)->full_name }}
                        </span>
                    </div>

                </div>

            @empty

                <div class="px-8 py-16 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 border border-gray-200 text-2xl mb-4">
                        📭
                    </div>
                    <p class="text-sm font-medium text-gray-600">No announcements have been posted yet.</p>
                    <p class="text-xs text-gray-400 mt-1">Post one to keep employees informed.</p>
                </div>

            @endforelse

        </div>

    </div>

</div>

</x-layouts.admin-layout>