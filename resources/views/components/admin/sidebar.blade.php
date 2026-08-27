<aside class="fixed left-0 top-0 flex h-screen w-64 flex-col border-r border-indigo-100 bg-gradient-to-b from-indigo-50 via-blue-50 to-white shadow-lg">

    {{-- Logo --}}
    <div class="border-b border-indigo-300 px-6 py-6">

        <h1 class="text-base font-bold leading-tight text-slate-800">
            Municipality of Santa Cruz
        </h1>

        <p class="mt-1 text-center text-xs font-medium text-indigo-600">
            Administrator Portal
        </p>

    </div>

    {{-- Navigation --}}
    <nav class="mt-5 flex-1 px-3">

        <ul class="space-y-2">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('admin.dashboard')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.75z"/>
                    </svg>

                    <span>Dashboard</span>

                </a>
            </li>

            {{-- Forward Document --}}
            <li>
                <a href="{{ route('admin.submit') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('admin.submit')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 5v14m7-7H5"/>
                    </svg>

                    <span>Forward Document</span>

                </a>
            </li>

            {{-- Incoming Documents --}}
            <li>
                <a href="{{ route('admin.documents') }}"
                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('admin.documents')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <div class="flex items-center gap-3">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M4 4h16v10H4V4zm4 14h8m-4-4v8"/>
                        </svg>

                        <span>Incoming Documents</span>

                    </div>



                </a>
            </li>

            {{-- Electronic Filing --}}
            <li>
                <a href="{{ route('admin.filing.index') }}"
                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('admin.filing.*')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <div class="flex items-center gap-3">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M4 7h16M4 12h16M4 17h10"/>
                        </svg>

                        <span>Electronic Filing</span>

                    </div>

                </a>
            </li>

            {{-- User Management --}}
            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('admin.users.*')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <div class="flex items-center gap-3">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M17 20h5V18a4 4 0 00-4-4h-1m-2-4a4 4 0 10-8 0 4 4 0 008 0zm-9 10H2v-2a4 4 0 014-4h4"/>
                        </svg>

                        <span>User Management</span>

                    </div>

                </a>
            </li>

            {{-- Announcements --}}
            <li>
                <a href="{{ route('admin.announcements') }}"
                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('admin.announcements')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <div class="flex items-center gap-3">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M11 5l7 7-7 7M4 5l7 7-7 7"/>
                        </svg>

                        <span>Announcements</span>

                    </div>


                </a>
            </li>

            {{-- Audit Trail --}}
            <li>
                <a href="{{ route('admin.audit') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('admin.audit')
                        ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
                        : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 17v-6m3 6V7m3 10v-3"/>
                    </svg>

                    <span>Audit Trail</span>

                </a>
            </li>

            {{-- Analytics --}}
<li>
    <a href="{{ route('admin.analytics') }}"
       class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
       {{ request()->routeIs('admin.analytics*')
            ? 'bg-white text-indigo-600 shadow-md border border-indigo-100'
            : 'text-slate-600 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">

        <svg class="h-5 w-5"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             viewBox="0 0 24 24">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M4 19h16M7 16V8m5 8V5m5 11v-3"/>

        </svg>

        <span>Analytics</span>

    </a>
</li>

        </ul>

    </nav>

    {{-- Logout --}}
    <div class="border-t border-indigo-300 p-4">

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button
                class="flex w-full items-center justify-center rounded-xl bg-indigo-600 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">

                Logout

            </button>

        </form>

    </div>

</aside>