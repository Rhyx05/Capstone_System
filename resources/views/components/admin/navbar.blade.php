<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-indigo-100 bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-6 shadow-sm">

    {{-- Left --}}
    <div></div>

    {{-- Right --}}
    <div class="flex items-center gap-4">

        {{-- Notification --}}
        <button
            class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-indigo-100 bg-white text-indigo-600 shadow-sm transition hover:bg-indigo-50">

            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0h6z"/>
            </svg>

            <span
                class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-indigo-600 text-[10px] font-bold text-white">

                5

            </span>

        </button>

        {{-- User --}}
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

                    {{ trim(auth()->user()->first_name . ' ' . auth()->user()->last_name) }}

                </div>

                <div class="text-xs capitalize text-slate-500">

                    Administrator

                </div>

            </div>

        </div>

    </div>

</header>