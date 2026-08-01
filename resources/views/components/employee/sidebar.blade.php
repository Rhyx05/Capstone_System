<aside class="fixed left-0 top-0 w-64 h-screen bg-gradient-to-b from-slate-900 via-slate-800 to-slate-950 text-white shadow-2xl flex flex-col">

    {{-- Logo --}}
    <div class="px-6 py-7 border-b border-slate-700">

        <h1 class="text-m font-bold leading-tight">
            Municipality of Santa Cruz
        </h1>

        <p class="mt-2 text-sm text-slate-300">
            Employee Portal
        </p>

    </div>

    {{-- Navigation --}}
    <nav class="flex-1 mt-6 px-4">

        <ul class="space-y-2">

            <li>
                <a href="{{ route('user.dashboard') }}"
                class="flex items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('user.dashboard') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    🏠&nbsp;&nbsp;Dashboard

                </a>
            </li>

            <li>
                <a href="{{ route('user.submit') }}"
                class="flex items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('user.submit') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    📄&nbsp;&nbsp;Submit Document

                </a>
            </li>

            <li>
                <a href="{{ route('user.documents') }}"
                class="flex justify-between items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('user.documents') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    <span>📁 My Documents</span>

                    <span class="bg-blue-600 text-white text-xs rounded-full px-2">

                        2

                    </span>

                </a>
            </li>

            <li>
                <a href="{{ route('user.incoming') }}"
                class="flex justify-between items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('user.incoming') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    <span>📥 Incoming Documents</span>

                    <span class="bg-red-600 text-white text-xs rounded-full px-2">

                        3

                    </span>

                </a>
            </li>

            <li>
    <a href="{{ route('user.history') }}"
    class="flex items-center px-4 py-3 rounded-xl transition
    {{ request()->routeIs('user.history') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

        📜&nbsp;&nbsp;History Logs

    </a>
</li>

            <li>
                <a href="{{ route('user.settings') }}"
                class="flex items-center px-4 py-3 rounded-xl transition
                {{ request()->routeIs('user.settings') ? 'bg-white text-black font-semibold' : 'hover:bg-slate-700 text-gray-300' }}">

                    ⚙&nbsp;&nbsp;Settings

                </a>
            </li>

        </ul>

    </nav>

    {{-- Logout --}}
    <div class="p-4 border-t border-slate-700">

        <form action="{{ route('logout') }}" method="POST">

            @csrf

            <button class="w-full py-3 rounded-xl bg-slate-800 hover:bg-red-600 transition">

                🚪 Logout

            </button>

        </form>

    </div>

</aside>