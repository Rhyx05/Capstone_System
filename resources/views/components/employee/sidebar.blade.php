<aside class="fixed left-0 top-0 flex h-screen w-64 flex-col border-r border-indigo-100 bg-gradient-to-b from-indigo-50 via-blue-50 to-white shadow-lg">

    {{-- Logo --}}
    <div class="border-b border-indigo-300 px-6 py-6">

        <h1 class="text-base font-bold leading-tight text-slate-800">
            Municipality of Santa Cruz
        </h1>

        <p class="mt-1 text-center text-xs font-medium text-indigo-600">
            Employee Portal
        </p>

    </div>

    {{-- Navigation --}}
    <nav class="mt-5 flex-1 px-3">

        <ul class="space-y-2">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('user.dashboard') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('user.dashboard')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.75z"/>
                    </svg>

                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Submit --}}
            <li>
                <a href="{{ route('user.submit') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('user.submit')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 5v14m7-7H5"/>
                    </svg>

                    <span>Submit Document</span>
                </a>
            </li>

            {{-- Documents --}}
            <li>
                <a href="{{ route('user.documents') }}"
                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('user.documents')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <div class="flex items-center gap-3">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                        </svg>

                        <span>My Documents</span>

                    </div>

                    <span class="rounded-full bg-indigo-600 px-2 py-0.5 text-[11px] font-semibold text-white">
                        2
                    </span>

                </a>
            </li>

            {{-- Incoming --}}
            <li>
                <a href="{{ route('user.incoming') }}"
                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('user.incoming')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <div class="flex items-center gap-3">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 4h16v10H4V4zm4 14h8m-4-4v8"/>
                        </svg>

                        <span>Incoming</span>

                    </div>

                    <span class="rounded-full bg-red-500 px-2 py-0.5 text-[11px] font-semibold text-white">
                        3
                    </span>

                </a>
            </li>

            {{-- History --}}
            <li>
                <a href="{{ route('user.history') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('user.history')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v5l3 3M12 22a10 10 0 100-20 10 10 0 000 20z"/>
                    </svg>

                    <span>History Logs</span>
                </a>
            </li>

            {{-- Settings --}}
            <li>
                <a href="{{ route('user.settings') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('user.settings')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15.5A3.5 3.5 0 1012 8.5a3.5 3.5 0 000 7zm7-3.5l2-1-2-1-.5-2.1-2-.6-1-2-2.1.5L12 3l-1.4 1.8-2.1-.5-1 2-2 .6L5 10l-2 1 2 1 .5 2.1 2 .6 1 2 2.1-.5L12 21l1.4-1.8 2.1.5 1-2 2-.6L19 12z"/>
                    </svg>

                    <span>Settings</span>
                </a>
            </li>

        </ul>

    </nav>

    {{-- Logout --}}
    <div class="border-t border-indigo-300 p-4">

        <form action="{{ route('logout') }}" method="POST">

            @csrf

            <button
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">

                Logout

            </button>

        </form>

    </div>

</aside>