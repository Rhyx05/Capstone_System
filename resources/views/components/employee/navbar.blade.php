<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-indigo-100 bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-6 shadow-sm">

    @php

        /*
        |--------------------------------------------------------------------------
        | Notification Data
        |--------------------------------------------------------------------------
        */

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


    {{-- ====================================================================== --}}
    {{-- LEFT --}}
    {{-- ====================================================================== --}}

    <div></div>


    {{-- ====================================================================== --}}
    {{-- RIGHT --}}
    {{-- ====================================================================== --}}

    <div class="relative flex items-center gap-4">


        {{-- ================================================================== --}}
        {{-- NOTIFICATION BUTTON --}}
        {{-- ================================================================== --}}

        <button
            id="notificationButton"
            type="button"
            class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-indigo-100 bg-white text-indigo-600 shadow-sm transition hover:bg-indigo-50"
        >

            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0h6z"
                />

            </svg>


            {{-- Notification Badge --}}

            <span
                id="notificationBadge"
                class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-indigo-600 text-[10px] font-bold text-white {{ $unreadNotifications > 0 ? '' : 'hidden' }}"
            >
                {{ $unreadNotifications }}
            </span>

        </button>


        {{-- ================================================================== --}}
        {{-- NOTIFICATION DROPDOWN --}}
        {{-- ================================================================== --}}

        <div
            id="notificationDropdown"
            class="hidden absolute right-0 top-14 z-50 w-96 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-2xl"
        >

            {{-- Dropdown Header --}}

            <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50 px-5 py-4">

                <h2 class="font-semibold text-gray-800">
                    Notifications
                </h2>

            </div>


            {{-- Notification Body --}}

            <div
                id="notificationBody"
                class="max-h-[420px] overflow-y-auto"
            >

                @forelse($latestNotifications as $notification)

                    <button
                        type="button"
                        data-notification-id="{{ $notification->id }}"
                        data-notification-type="{{ $notification->type }}"
                        data-document-id="{{ $notification->document_id ?? '' }}"
                        class="notification-item block w-full border-b border-gray-100 px-5 py-4 text-left transition hover:bg-indigo-50"
                    >

                        <div class="flex items-start justify-between">

                            <div class="min-w-0">

                                <div class="text-sm font-semibold text-gray-800">
                                    {{ $notification->title }}
                                </div>

                                <div class="mt-1 text-sm text-gray-500">
                                    {{ $notification->message }}
                                </div>

                                <div class="mt-2 text-xs text-gray-400">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>

                            </div>


                            {{-- Unread Indicator --}}

                            @unless($notification->is_read)

                                <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-indigo-600"></span>

                            @endunless

                        </div>

                    </button>

                @empty

                    <div class="py-10 text-center text-gray-400">
                        No notifications.
                    </div>

                @endforelse

            </div>

        </div>


        {{-- ================================================================== --}}
        {{-- USER INFORMATION --}}
        {{-- ================================================================== --}}

        <div class="flex items-center gap-3 rounded-xl px-3 py-2">

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100">

                <svg
                    class="h-5 w-5 text-indigo-600"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5.1 20a7 7 0 0113.8 0M12 12a4 4 0 100-8 4 4 0 000 8z"
                    />

                </svg>

            </div>


            <div class="leading-tight">

                <div class="text-sm font-semibold text-slate-800">
                    {{ auth()->user()->full_name }}
                </div>

                <div class="text-xs capitalize text-slate-500">
                    {{ auth()->user()->role }}
                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================================== --}}
    {{-- JAVASCRIPT --}}
    {{-- ====================================================================== --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const notificationButton =
            document.getElementById('notificationButton');

        const notificationDropdown =
            document.getElementById('notificationDropdown');

        const notificationBody =
            document.getElementById('notificationBody');

        const notificationBadge =
            document.getElementById('notificationBadge');


        /*
        |--------------------------------------------------------------------------
        | Initial unread count
        |--------------------------------------------------------------------------
        */

        let previousUnreadCount =
            {{ $unreadNotifications }};


        /*
        |--------------------------------------------------------------------------
        | Laravel-generated URLs
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | We generate the URLs from Laravel instead of hardcoding:
        |
        | /notifications/...
        |
        | because the actual employee routes are:
        |
        | /user/notifications/...
        |
        */

        const notificationReadUrlTemplate =
            "{{ route('user.notifications.read', ['notification' => '__NOTIFICATION_ID__']) }}";


        const notificationLiveUrl =
            "{{ route('user.notifications.live') }}";


        const incomingDocumentUrlTemplate =
            "{{ route('user.incoming.show', ['document' => '__DOCUMENT_ID__']) }}";


        const documentUrlTemplate =
            "{{ route('user.documents.show', ['document' => '__DOCUMENT_ID__']) }}";


        /*
        |--------------------------------------------------------------------------
        | Dropdown Toggle
        |--------------------------------------------------------------------------
        */

        notificationButton.addEventListener('click', function (event) {

            event.stopPropagation();

            notificationDropdown.classList.toggle('hidden');

        });


        /*
        |--------------------------------------------------------------------------
        | Close Dropdown When Clicking Outside
        |--------------------------------------------------------------------------
        */

        document.addEventListener('click', function () {

            notificationDropdown.classList.add('hidden');

        });


        /*
        |--------------------------------------------------------------------------
        | Prevent Dropdown From Closing When Clicking Inside
        |--------------------------------------------------------------------------
        */

        notificationDropdown.addEventListener('click', function (event) {

            event.stopPropagation();

        });


        /*
        |--------------------------------------------------------------------------
        | Escape HTML
        |--------------------------------------------------------------------------
        |
        | This prevents notification text from being interpreted as HTML.
        |
        */

        function escapeHtml(value) {

            if (value === null || value === undefined) {

                return '';

            }

            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

        }


        /*
        |--------------------------------------------------------------------------
        | Mark Notification As Read
        |--------------------------------------------------------------------------
        */

        async function markNotificationRead(
            notificationId,
            notificationType,
            documentId
        ) {

            try {

                /*
                |--------------------------------------------------------------------------
                | Build Correct Laravel POST URL
                |--------------------------------------------------------------------------
                */

                const readUrl =
                    notificationReadUrlTemplate.replace(
                        '__NOTIFICATION_ID__',
                        notificationId
                    );


                /*
                |--------------------------------------------------------------------------
                | Mark Notification As Read
                |--------------------------------------------------------------------------
                */

                const response = await fetch(readUrl, {

                    method: 'POST',

                    headers: {

                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            ).getAttribute('content'),

                        'Accept': 'application/json',

                        'X-Requested-With': 'XMLHttpRequest',

                    },

                });


                /*
                |--------------------------------------------------------------------------
                | Check Response
                |--------------------------------------------------------------------------
                */

                if (!response.ok) {

                    console.error(
                        'Unable to mark notification as read.',
                        response.status
                    );

                }


            } catch (error) {

                console.error(
                    'Notification read error:',
                    error
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Navigate To Related Record
            |--------------------------------------------------------------------------
            */

            if (documentId) {

                /*
                |--------------------------------------------------------------------------
                | Assigned notification
                |--------------------------------------------------------------------------
                |
                | Assigned documents belong to Incoming Documents.
                |
                */

                if (notificationType === 'assigned') {

                    const incomingUrl =
                        incomingDocumentUrlTemplate.replace(
                            '__DOCUMENT_ID__',
                            documentId
                        );

                    window.location.href = incomingUrl;

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Other document notifications
                |--------------------------------------------------------------------------
                */

                const documentUrl =
                    documentUrlTemplate.replace(
                        '__DOCUMENT_ID__',
                        documentId
                    );

                window.location.href = documentUrl;

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | No Document Attached
            |--------------------------------------------------------------------------
            */

            await loadNotifications();

        }


        /*
        |--------------------------------------------------------------------------
        | Handle Notification Clicks
        |--------------------------------------------------------------------------
        */

        notificationBody.addEventListener(
            'click',
            function (event) {

                const notification =
                    event.target.closest(
                        '.notification-item'
                    );


                if (!notification) {

                    return;

                }


                const notificationId =
                    notification.dataset.notificationId;


                const notificationType =
                    notification.dataset.notificationType;


                const documentId =
                    notification.dataset.documentId;


                markNotificationRead(
                    notificationId,
                    notificationType,
                    documentId || null
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Load Notifications
        |--------------------------------------------------------------------------
        */

        async function loadNotifications() {

            try {

                const response =
                    await fetch(notificationLiveUrl, {

                        headers: {

                            'Accept': 'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                    });


                if (!response.ok) {

                    throw new Error(
                        'Notification request failed: ' +
                        response.status
                    );

                }


                const data =
                    await response.json();


                /*
                |--------------------------------------------------------------------------
                | Update Badge
                |--------------------------------------------------------------------------
                */

                if (data.count > 0) {

                    notificationBadge.innerText =
                        data.count;

                    notificationBadge.classList.remove(
                        'hidden'
                    );

                } else {

                    notificationBadge.classList.add(
                        'hidden'
                    );

                    notificationBadge.innerText = '0';

                }


                /*
                |--------------------------------------------------------------------------
                | Bell Animation
                |--------------------------------------------------------------------------
                */

                if (
                    data.count >
                    previousUnreadCount
                ) {

                    notificationButton.classList.add(
                        'animate-bounce'
                    );


                    setTimeout(function () {

                        notificationButton.classList.remove(
                            'animate-bounce'
                        );

                    }, 1200);

                }


                previousUnreadCount =
                    data.count;


                /*
                |--------------------------------------------------------------------------
                | Notification List
                |--------------------------------------------------------------------------
                */

                let html = '';


                if (
                    data.notifications &&
                    data.notifications.length > 0
                ) {

                    data.notifications.forEach(
                        function (notification) {

                            const documentId =
                                notification.document_id
                                    ?? '';


                            html += `

                                <button
                                    type="button"

                                    data-notification-id="${escapeHtml(notification.id)}"

                                    data-notification-type="${escapeHtml(notification.type)}"

                                    data-document-id="${escapeHtml(documentId)}"

                                    class="notification-item block w-full border-b border-gray-100 px-5 py-4 text-left transition hover:bg-indigo-50"
                                >

                                    <div class="flex items-start justify-between">

                                        <div class="min-w-0">

                                            <div class="text-sm font-semibold text-gray-800">

                                                ${escapeHtml(notification.title)}

                                            </div>

                                            <div class="mt-1 text-sm text-gray-500">

                                                ${escapeHtml(notification.message)}

                                            </div>

                                            <div class="mt-2 text-xs text-gray-400">

                                                ${escapeHtml(notification.time)}

                                            </div>

                                        </div>


                                        ${
                                            notification.is_read

                                                ? ''

                                                : `
                                                    <span
                                                        class="mt-2 h-2 w-2 shrink-0 rounded-full bg-indigo-600">
                                                    </span>
                                                  `
                                        }

                                    </div>

                                </button>

                            `;

                        }
                    );

                } else {

                    html = `

                        <div class="py-10 text-center text-gray-400">

                            No notifications.

                        </div>

                    `;

                }


                notificationBody.innerHTML =
                    html;


            } catch (error) {

                console.error(
                    'Notification Error:',
                    error
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Initial Load
        |--------------------------------------------------------------------------
        */

        loadNotifications();


        /*
        |--------------------------------------------------------------------------
        | Auto Refresh
        |--------------------------------------------------------------------------
        |
        | Refresh every 10 seconds.
        |
        */

        setInterval(
            loadNotifications,
            10000
        );

    </script>

</header>