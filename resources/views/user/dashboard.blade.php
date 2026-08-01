<x-layouts.employee-layout>

<div class="max-w-5xl mx-auto">

    <div class="mb-8">

        <h1 class="text-3xl font-bold">

            Employee Dashboard

        </h1>

        <p class="mt-2 text-gray-500">

            View the latest announcements from the administration.

        </p>

    </div>

    <div class="bg-white rounded-2xl shadow border">

        <div class="border-b px-6 py-4">

            <h2 class="text-xl font-bold">

                📢 Announcements

            </h2>

        </div>

        <div class="divide-y">

            @forelse($announcements as $announcement)

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <h3 class="text-xl font-semibold">

                            @if($announcement->is_pinned)

                                📌

                            @endif

                            {{ $announcement->title }}

                        </h3>

                        <span class="text-sm text-gray-500">

                            {{ optional($announcement->published_at)->format('M d, Y h:i A') }}

                        </span>

                    </div>

                    <div class="mt-4 whitespace-pre-line text-gray-700 leading-7">

                        {{ $announcement->content }}

                    </div>

                    <div class="mt-4 text-sm text-gray-500">

                        Posted by

                        <strong>

                            {{ optional($announcement->author)->full_name }}

                        </strong>

                    </div>

                </div>

            @empty

                <div class="p-10 text-center text-gray-500">

                    <div class="text-5xl mb-4">

                        📭

                    </div>

                    <p>

                        No announcements have been posted yet.

                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

</x-layouts.employee-layout>