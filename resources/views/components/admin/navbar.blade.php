<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-indigo-100 bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-6 shadow-sm">

@php

$unreadNotifications = auth()->user()
    ->notifications()
    ->where('is_read', false)
    ->count();

$latestNotifications = auth()->user()
    ->notifications()
    ->latest()
    ->take(5)
    ->get();

@endphp

    {{-- Left --}}
    <div></div>

    {{-- Right --}}
    <div class="flex items-center gap-4 relative">

        {{-- ================= Notification Bell ================= --}}
        <button
            id="notificationButton"
            type="button"
            class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-indigo-100 bg-white text-indigo-600 shadow-sm transition hover:bg-indigo-50">

            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0h6z"/>

            </svg>

            <span
                id="notificationCount"
                class="{{ $unreadNotifications ? '' : 'hidden' }} absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-indigo-600 text-[10px] font-bold text-white">

                {{ $unreadNotifications }}

            </span>

        </button>

        {{-- ================= Notification Dropdown ================= --}}
        <div
            id="notificationDropdown"
            class="hidden absolute right-0 top-14 w-96 rounded-2xl bg-white border border-gray-200 shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">

                <h2 class="font-semibold text-gray-800">

                    Notifications

                </h2>

                @if($unreadNotifications)

                    <form
                        action="{{ route('admin.notifications.readAll') }}"
                        method="POST">

                        @csrf

                        <button
                            class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">

                            Mark all as read

                        </button>

                    </form>

                @endif

            </div>

            {{-- Notification List --}}
            <div
                id="notificationBody"
                class="max-h-96 overflow-y-auto">

                @forelse($latestNotifications as $notification)

                    <form
                        action="{{ route('admin.notifications.read',$notification) }}"
                        method="POST">

                        @csrf

                        <button
                            type="submit"
                            class="w-full text-left">

                            <div class="px-5 py-4 border-b border-gray-100 hover:bg-indigo-50 transition">

                                <div class="flex items-start justify-between">

                                    <div>

                                        <div class="font-semibold text-sm text-gray-800">

                                            {{ $notification->title }}

                                        </div>

                                        <div class="text-sm text-gray-500 mt-1">

                                            {{ $notification->message }}

                                        </div>

                                        <div class="text-xs text-gray-400 mt-2">

                                            {{ $notification->created_at->diffForHumans() }}

                                        </div>

                                    </div>

                                    @unless($notification->is_read)

                                        <span class="mt-2 h-2 w-2 rounded-full bg-indigo-600"></span>

                                    @endunless

                                </div>

                            </div>

                        </button>

                    </form>

                @empty

                    <div class="py-10 text-center text-gray-400">

                        No notifications.

                    </div>

                @endforelse

            </div>

            {{-- Footer --}}
            <div class="border-t bg-gray-50">

                <a
                    href="{{ route('admin.notifications.index') }}"
                    class="block py-3 text-center text-sm font-semibold text-indigo-600 hover:bg-indigo-100">

                    View All Notifications

                </a>

            </div>

        </div>

        {{-- ================= User ================= --}}
        <div class="flex items-center gap-3 rounded-xl px-3 py-2">

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100">

                <svg
                    class="h-5 w-5 text-indigo-600"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5.1 20a7 7 0 0113.8 0M12 12a4 4 0 100-8 4 4 0 000 8z"/>

                </svg>

            </div>

            <div class="leading-tight">

                <div class="text-sm font-semibold text-slate-800">

                    {{ auth()->user()->full_name }}

                </div>

                <div class="text-xs text-slate-500">

                    Administrator

                </div>

            </div>

        </div>

    </div>
    </header>

<script>

const notificationButton = document.getElementById('notificationButton');
const notificationDropdown = document.getElementById('notificationDropdown');
const notificationBadge = document.getElementById('notificationCount');
const notificationBody = document.getElementById('notificationBody');

let previousUnreadCount = {{ $unreadNotifications }};

/*
|--------------------------------------------------------------------------
| Toggle Dropdown
|--------------------------------------------------------------------------
*/

notificationButton.addEventListener('click', function (e) {

    e.stopPropagation();

    notificationDropdown.classList.toggle('hidden');

});

document.addEventListener('click', function () {

    notificationDropdown.classList.add('hidden');

});

notificationDropdown.addEventListener('click', function (e) {

    e.stopPropagation();

});

/*
|--------------------------------------------------------------------------
| Open Notification
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Open Notification
|--------------------------------------------------------------------------
*/

async function openNotification(id, url)
{
    try {

        const response = await fetch(`/admin/notifications/${id}/read`, {

            method: 'POST',

            headers: {

                'X-CSRF-TOKEN': '{{ csrf_token() }}',

                'X-Requested-With': 'XMLHttpRequest',

                'Accept': 'application/json',

                'Content-Type': 'application/json'

            }

        });

        if(response.ok){

            loadNotifications();

        }

    } catch(error){

        console.error(error);

    }

    window.location.href = url;

}

/*
|--------------------------------------------------------------------------
| Load Notifications
|--------------------------------------------------------------------------
*/

async function loadNotifications() {

    try {

        const response = await fetch("{{ route('admin.notifications.live') }}");

        const data = await response.json();

        /*
        |--------------------------------------------------------------------------
        | Update Badge
        |--------------------------------------------------------------------------
        */

        if (data.count > 0) {

            notificationBadge.classList.remove('hidden');

            notificationBadge.innerText = data.count;

        } else {

            notificationBadge.classList.add('hidden');

        }

        /*
        |--------------------------------------------------------------------------
        | Bell Animation
        |--------------------------------------------------------------------------
        */

        if (data.count > previousUnreadCount) {

            notificationButton.classList.add('animate-bounce');

            setTimeout(() => {

                notificationButton.classList.remove('animate-bounce');

            }, 1200);

        }

        previousUnreadCount = data.count;

        /*
        |--------------------------------------------------------------------------
        | Update Notification List
        |--------------------------------------------------------------------------
        */

        let html = '';

        if (data.notifications.length > 0) {

            data.notifications.forEach(notification => {

                html += `
                <div
                    onclick="openNotification(${notification.id}, '${notification.url}')"
                    class="cursor-pointer px-5 py-4 border-b border-gray-100 hover:bg-indigo-50 transition">

                    <div class="flex items-start justify-between">

                        <div class="flex-1">

                            <div class="font-semibold text-sm text-gray-800">

                                ${notification.title}

                            </div>

                            <div class="text-sm text-gray-500 mt-1">

                                ${notification.message}

                            </div>

                            <div class="text-xs text-gray-400 mt-2">

                                ${notification.time}

                            </div>

                        </div>

                        ${
                            notification.is_read
                            ? ''
                            : `<span class="mt-2 ml-3 h-2.5 w-2.5 rounded-full bg-indigo-600"></span>`
                        }

                    </div>

                </div>
                `;

            });

        } else {

            html = `
                <div class="py-10 text-center text-gray-400">

                    No notifications.

                </div>
            `;

        }

        notificationBody.innerHTML = html;

    } catch (error) {

        console.error('Notification Error:', error);

    }

}

/*
|--------------------------------------------------------------------------
| Auto Refresh Every 10 Seconds
|--------------------------------------------------------------------------
*/

loadNotifications();

setInterval(loadNotifications, 10000);

</script>