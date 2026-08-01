<aside class="fixed left-0 top-0 w-64 h-screen bg-gradient-to-b from-slate-900 via-slate-800 to-slate-950 text-white shadow-2xl flex flex-col">

    {{-- Logo --}}
    <div class="px-6 py-7 border-b border-slate-700">

                <h1 class="text-m font-bold text-white leading-tight">
            Municipality of Santa Cruz
        </h1>

        <p class="mt-2 text-sm text-slate-300">
            Administrator Portal
        </p>

    </div>

    {{-- Navigation --}}
    <nav class="flex-1 mt-6 px-4">

        <ul class="space-y-2">

            <li>
                <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.dashboard') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    🏠&nbsp;&nbsp;Dashboard

                </a>
            </li>

            <li>
                <a href="{{ route('admin.submit') }}"
                class="flex items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.submit') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    📄&nbsp;&nbsp;Forward Document

                </a>
            </li>

            <li>
                <a href="{{ route('admin.documents') }}"
                class="flex justify-between items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.documents') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    <span>📥 Incoming Documents</span>

                    <span class="bg-red-600 text-white text-xs rounded-full px-2">
                        5
                    </span>

                </a>
            </li>

<li>
    <a href="{{ route('admin.filing.index') }}"
    class="flex justify-between items-center px-4 py-3 rounded-xl transition
    {{ request()->routeIs('admin.filing.*') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

        <span>🗂️ Electronic Filing</span>

        <span class="bg-amber-600 text-white text-xs rounded-full px-2">
            {{ \App\Models\ElectronicFilingCategory::count() }}
        </span>

    </a>
</li>

<li>
    <a href="{{ route('admin.users.index') }}"
    class="flex justify-between items-center px-4 py-3 rounded-xl transition
    {{ request()->routeIs('admin.users.*') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

        <span>👥 User Management</span>

        <span class="bg-blue-600 text-white text-xs rounded-full px-2">
            {{ \App\Models\User::count() }}
        </span>

    </a>
</li>

            <li>
                <a href="{{ route('admin.announcements') }}"
                class="flex justify-between items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.announcements') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    <span>📢 Announcements</span>

                    <span class="bg-green-600 text-white text-xs rounded-full px-2">
                        2
                    </span>

                </a>
            </li>

            <li>
                <a href="{{ route('admin.audit') }}"
                class="flex items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.audit') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    📝&nbsp;&nbsp;Audit Trail

                </a>
            </li>

        </ul>

    </nav>

    {{-- Logout --}}
    <div class="p-4 border-t border-slate-700">

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button class="w-full py-3 rounded-xl bg-slate-800 hover:bg-red-600 transition">

                🚪 Logout

            </button>

        </form>

    </div>

</aside>