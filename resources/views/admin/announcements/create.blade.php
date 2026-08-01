<x-layouts.admin-layout>

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold">

            Create Announcement

        </h1>

        <p class="mt-2 text-gray-500">

            Publish announcements that will appear on both the Administrator and Employee dashboards.

        </p>

    </div>

    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-lg border border-red-300 bg-red-100 p-5">

            <ul class="list-disc pl-5 text-red-700">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- Form --}}
    <form
        method="POST"
        action="{{ route('admin.announcements.store') }}"
        class="space-y-6 rounded-xl bg-white p-8 shadow">

        @csrf

        {{-- Title --}}
        <div>

            <label class="mb-2 block font-semibold">

                Announcement Title

            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                required
                class="w-full rounded-lg border-gray-300"
                placeholder="Enter announcement title">

        </div>

        {{-- Content --}}
        <div>

            <label class="mb-2 block font-semibold">

                Announcement Content

            </label>

            <textarea
                name="content"
                rows="8"
                required
                class="w-full rounded-lg border-gray-300"
                placeholder="Write your announcement here...">{{ old('content') }}</textarea>

        </div>

        {{-- Options --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <label class="flex items-center gap-3">

                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    checked>

                <span>

                    Publish Immediately

                </span>

            </label>

            <label class="flex items-center gap-3">

                <input
                    type="checkbox"
                    name="is_pinned"
                    value="1">

                <span>

                    Pin this Announcement

                </span>

            </label>

        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.announcements') }}"
                class="rounded-lg bg-gray-200 px-6 py-3 hover:bg-gray-300">

                Cancel

            </a>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-8 py-3 text-white hover:bg-blue-700">

                📢 Publish Announcement

            </button>

        </div>

    </form>

</div>

</x-layouts.admin-layout>