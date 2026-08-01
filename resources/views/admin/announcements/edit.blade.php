<x-layouts.admin-layout>

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold">

            Edit Announcement

        </h1>

        <p class="mt-2 text-gray-500">

            Update this announcement.

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

    <form
        method="POST"
        action="{{ route('admin.announcements.update', $announcement) }}"
        class="space-y-6 rounded-xl bg-white p-8 shadow">

        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>

            <label class="mb-2 block font-semibold">

                Announcement Title

            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title', $announcement->title) }}"
                required
                class="w-full rounded-lg border-gray-300">

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
                class="w-full rounded-lg border-gray-300">{{ old('content', $announcement->content) }}</textarea>

        </div>

        {{-- Options --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <label class="flex items-center gap-3">

                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    {{ $announcement->is_published ? 'checked' : '' }}>

                <span>

                    Published

                </span>

            </label>

            <label class="flex items-center gap-3">

                <input
                    type="checkbox"
                    name="is_pinned"
                    value="1"
                    {{ $announcement->is_pinned ? 'checked' : '' }}>

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

                💾 Save Changes

            </button>

        </div>

    </form>

</div>

</x-layouts.admin-layout>