<div class="bg-white rounded-2xl border shadow-sm">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b px-6 py-5">

        <div>

            <h2 class="text-xl font-bold">
                Repositories
            </h2>

            <p class="text-sm text-gray-500">
                Manage Electronic Filing Categories
            </p>

        </div>

        <button
            type="button"
            onclick="openCreateCategoryModal()"
            class="rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 transition">

            + New Repository

        </button>

    </div>

    {{-- Repository Cards --}}
    <div class="p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            @forelse($repositories as $category)

                <div class="relative rounded-2xl border hover:shadow-lg transition duration-200 overflow-hidden bg-white">

                    {{-- ================================================= --}}
                    {{-- THREE DOT MENU --}}
                    {{-- ================================================= --}}

                    <div class="absolute top-4 right-4">

                        <button
                            type="button"
                            onclick="toggleMenu({{ $category->id }})"
                            class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center text-xl font-bold">

                            ⋮

                        </button>

                        <div
                            id="menu-{{ $category->id }}"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-xl shadow-xl z-50">

                            <button
                                type="button"
                                onclick="openEditCategoryModal(
                                    '{{ $category->id }}',
                                    '{{ addslashes($category->name) }}',
                                    '{{ addslashes($category->description) }}',
                                )"
                                class="w-full text-left px-4 py-3 hover:bg-gray-100">

                                ✏ Edit Repository

                            </button>

                            <button
                                type="button"
                                onclick="openDeleteCategoryModal(
                                    '{{ $category->id }}',
                                    '{{ addslashes($category->name) }}'
                                )"
                                class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50">

                                🗑 Delete Repository

                            </button>

                        </div>

                    </div>

                    {{-- ================================================= --}}
                    {{-- CARD CONTENT --}}
                    {{-- ================================================= --}}

                    <div class="p-6">

                        <div class="text-5xl mb-4">

                            {{ $category->icon ?: '📁' }}

                        </div>

                        <h3 class="text-lg font-bold text-gray-900">

                            {{ $category->name }}

                        </h3>

                        <p class="mt-2 text-sm text-gray-500 min-h-[48px]">

                            {{ $category->description ?: 'No description available.' }}

                        </p>

                        <div class="mt-5 flex items-center justify-between">

                            <span class="text-sm text-gray-600">

                                {{ $category->documents_count }}

                                {{ Str::plural('Document', $category->documents_count) }}

                            </span>


                        </div>

                    </div>

                    {{-- ================================================= --}}
                    {{-- FOOTER --}}
                    {{-- ================================================= --}}

                    <div class="border-t bg-gray-50 px-6 py-4">

                        <a
                            href="{{ route('admin.filing.repository', $category) }}"
                            class="text-blue-600 hover:text-blue-800 font-semibold">

                            View Repository →

                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-full text-center py-20">

                    <div class="text-6xl mb-5">

                        📂

                    </div>

                    <h3 class="text-2xl font-bold text-gray-700">

                        No Repositories Yet

                    </h3>

                    <p class="mt-3 text-gray-500">

                        Create your first Electronic Filing repository to begin organizing archived documents.

                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

<script>

function toggleMenu(id)
{
    document.querySelectorAll("[id^='menu-']").forEach(menu => {

        if(menu.id !== "menu-" + id){

            menu.classList.add("hidden");

        }

    });

    document
        .getElementById("menu-" + id)
        .classList
        .toggle("hidden");
}

document.addEventListener("click", function(e){

    if(!e.target.closest("[onclick^='toggleMenu']")){

        document.querySelectorAll("[id^='menu-']").forEach(menu=>{

            menu.classList.add("hidden");

        });

    }

});

</script>