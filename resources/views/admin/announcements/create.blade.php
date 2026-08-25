<x-layouts.admin-layout>

<div class="max-w-4xl mx-auto">

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
                    <h1 class="text-xl font-bold text-gray-900">Create Announcement</h1>
                    <p class="mt-0.5 text-sm text-gray-500">Publish announcements that will appear on both the Administrator and Employee dashboards.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mx-8 mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                <p class="font-semibold text-sm mb-1.5">Please correct the following errors:</p>
                <ul class="list-disc list-inside text-sm space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.announcements.store') }}">
            @csrf

            <div class="px-8 py-6 space-y-5">

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                        Announcement Title <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        required
                        placeholder="Enter announcement title"
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                {{-- Content --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                        Announcement Content <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="content"
                        rows="8"
                        required
                        placeholder="Write your announcement here..."
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('content') }}</textarea>
                </div>

                {{-- Options --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <label class="flex items-center gap-3 rounded-xl border border-gray-200 px-4 py-3 cursor-pointer hover:border-indigo-200 hover:bg-indigo-50/30 transition">
                        <input
                            type="checkbox"
                            name="is_published"
                            value="1"
                            checked
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700">Publish Immediately</span>
                    </label>

                    <label class="flex items-center gap-3 rounded-xl border border-gray-200 px-4 py-3 cursor-pointer hover:border-indigo-200 hover:bg-indigo-50/30 transition">
                        <input
                            type="checkbox"
                            name="is_pinned"
                            value="1"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700">📌 Pin this Announcement</span>
                    </label>

                </div>

            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3 px-8 py-5">
                <a
                    href="{{ route('admin.announcements') }}"
                    class="px-6 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">
                    📢 Publish Announcement
                </button>
            </div>

        </form>

    </div>

</div>

</x-layouts.admin-layout>