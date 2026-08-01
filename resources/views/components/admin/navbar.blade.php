<header class="sticky top-0 h-20 bg-white border-b shadow-sm flex justify-between items-center px-8 z-30">

    <div>



        <p class="text-sm text-gray-500">

        </p>

    </div>

    <div class="flex items-center gap-6">

        {{-- Notification --}}
        <button class="relative text-2xl">

            🔔

            <span class="absolute -top-2 -right-2 w-5 h-5 bg-blue-600 rounded-full text-white text-xs flex justify-center items-center">

                5

            </span>

        </button>

        {{-- User Dropdown --}}
        <x-dropdown align="right" width="56">

            <x-slot name="trigger">

                <button class="flex items-center gap-3 hover:bg-gray-100 rounded-xl px-3 py-2">

                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">

                        👤

                    </div>

                    <div class="text-left">

                        <div class="font-semibold">

                            {{ auth()->user()->name }}

                        </div>

                        <div class="text-xs text-gray-500">

                            Administrator

                        </div>

                    </div>

                </button>

            </x-slot>

            <x-slot name="content">

                <x-dropdown-link :href="route('admin.settings')">

                    Settings

                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <x-dropdown-link
                        :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">

                        Logout

                    </x-dropdown-link>

                </form>

            </x-slot>

        </x-dropdown>

    </div>

</header>