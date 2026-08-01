<x-layouts.admin-layout>

@if(session('success'))
<div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-6 py-4 text-green-700">
    {{ session('success') }}
</div>
@endif

<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold">
                Announcements
            </h1>

            <p class="mt-1 text-gray-500">
                Create and manage announcements for all employees.
            </p>

        </div>

        <a
            href="{{ route('admin.announcements.create') }}"
            class="rounded-lg bg-blue-600 px-6 py-3 text-white hover:bg-blue-700">

            + New Announcement

        </a>

    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow">

        <table class="min-w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="px-6 py-4 text-left">
                        Title
                    </th>

                    <th class="px-6 py-4 text-center">
                        Status
                    </th>

                    <th class="px-6 py-4 text-center">
                        Pinned
                    </th>

                    <th class="px-6 py-4 text-center">
                        Posted By
                    </th>

                    <th class="px-6 py-4 text-center">
                        Date
                    </th>

                    <th class="px-6 py-4 text-center">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($announcements as $announcement)

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-6 py-5">

                        <div class="font-semibold">

                            {{ $announcement->title }}

                        </div>

                        <div class="mt-1 text-sm text-gray-500">

                            {{ \Illuminate\Support\Str::limit($announcement->content, 100) }}

                        </div>

                    </td>

                    <td class="px-6 py-5 text-center">

                        @if($announcement->is_published)

                            <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">

                                Published

                            </span>

                        @else

                            <span class="rounded-full bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700">

                                Draft

                            </span>

                        @endif

                    </td>

                    <td class="px-6 py-5 text-center">

                        @if($announcement->is_pinned)

                            <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-700">

                                📌 Pinned

                            </span>

                        @else

                            —

                        @endif

                    </td>

                    <td class="px-6 py-5 text-center">

                        {{ optional($announcement->author)->full_name }}

                    </td>

                    <td class="px-6 py-5 text-center">

                        {{ optional($announcement->published_at)->format('M d, Y h:i A') }}

                    </td>

                    <td class="px-6 py-5">

                        <div class="flex justify-center gap-2">

                            <a
                                href="{{ route('admin.announcements.edit', $announcement) }}"
                                class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">

                                Edit

                            </a>

                            <form
                                method="POST"
                                action="{{ route('admin.announcements.destroy', $announcement) }}"
                                onsubmit="return confirm('Delete this announcement?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="6"
                        class="py-12 text-center text-gray-500">

                        No announcements have been posted yet.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        @if($announcements->count())

        <div class="border-t p-5">

            {{ $announcements->links() }}

        </div>

        @endif

    </div>

</div>

</x-layouts.admin-layout>