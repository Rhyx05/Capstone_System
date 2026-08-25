<x-layouts.admin-layout>

<div class="max-w-7xl mx-auto space-y-6">

    {{-- ========================================================= --}}
    {{-- Notification Center Card --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white border border-indigo-100 shadow-sm">

                        🔔

                    </div>

                    <div>

                        <h1 class="text-xl font-bold text-gray-900">
                            Notification Center
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Stay updated with document activities and system events.
                        </p>

                    </div>

                </div>

                <form
                    action="{{ route('admin.notifications.readAll') }}"
                    method="POST">

                    @csrf

                    <button
                        class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition">

                        ✓ Mark All as Read

                    </button>

                </form>

            </div>

        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Notifications --}}
        <div>

            @forelse($notifications as $notification)

                <div class="flex items-start justify-between gap-6 p-6 border-b border-gray-100 transition hover:bg-gray-50 {{ !$notification->is_read ? 'bg-indigo-50/40 border-l-4 border-l-indigo-500' : '' }}">

                    <div class="flex gap-4">

                        {{-- Icon --}}
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-xl">

                            @switch($notification->type)

                                @case('document')
                                    📄
                                    @break

                                @case('approval')
                                    ✅
                                    @break

                                @case('returned')
                                    ↩️
                                    @break

                                @case('routed')
                                    📤
                                    @break

                                @case('archive')
                                    🗂️
                                    @break

                                @case('announcement')
                                    📢
                                    @break

                                @default
                                    🔔

                            @endswitch

                        </div>

                        {{-- Content --}}
                        <div>

                            <h2 class="font-semibold text-gray-900">

                                {{ $notification->title }}

                            </h2>

                            <p class="text-sm text-gray-600 mt-1">

                                {{ $notification->message }}

                            </p>

                            <p class="text-xs text-gray-400 mt-3">

                                {{ $notification->created_at->diffForHumans() }}

                            </p>

                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col items-end gap-2">

                        @if(!$notification->is_read)

                            <span class="text-xs px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 font-semibold">

                                Unread

                            </span>

                        @else

                            <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">

                                Read

                            </span>

                        @endif

                        @if($notification->document_id)

                            <a
                                href="{{ route('admin.documents.show', $notification->document_id) }}"
                                class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">

                                View Document →

                            </a>

                        @endif

                    </div>

                </div>

            @empty

                <div class="py-20 text-center">

                    <div class="text-6xl">

                        🔕

                    </div>

                    <h2 class="mt-4 text-lg font-semibold text-gray-800">

                        No Notifications

                    </h2>

                    <p class="text-sm text-gray-500 mt-2">

                        You're all caught up.

                    </p>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())

            <div class="border-t border-gray-100 px-6 py-5">

                {{ $notifications->links() }}

            </div>

        @endif

    </div>

</div>

</x-layouts.admin-layout>