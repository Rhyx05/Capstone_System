<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    {{-- Total Repositories --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-3xl">
                📂
            </div>

            <div>
                <p class="text-sm text-gray-500 uppercase">
                    Repositories
                </p>

                <h2 class="text-3xl font-bold">
                   {{ $totalRepositories }}
                </h2>

                <p class="text-gray-500 text-sm">
                    Filing Categories
                </p>
            </div>
        </div>
    </div>

    {{-- Archived Documents --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-3xl">
                📄
            </div>

            <div>
                <p class="text-sm text-gray-500 uppercase">
                    Archived Documents
                </p>

                <h2 class="text-3xl font-bold">
                    {{ $archivedDocuments }}
                </h2>

                <p class="text-gray-500 text-sm">
                    Total Archived Files
                </p>
            </div>
        </div>
    </div>

    {{-- Today's Archives --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center text-3xl">
                📅
            </div>

            <div>
                <p class="text-sm text-gray-500 uppercase">
                    Today's Archives
                </p>

                <h2 class="text-3xl font-bold">
                    {{ $todayArchives }}
                </h2>

                <p class="text-gray-500 text-sm">
                    Archived Today
                </p>
            </div>
        </div>
    </div>

    {{-- Storage --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center text-3xl">
                💾
            </div>

            <div>
                <p class="text-sm text-gray-500 uppercase">
                    Storage Used
                </p>

                <h2 class="text-3xl font-bold">
                  {{ number_format($storageUsed / 1024 / 1024, 2) }} MB
                </h2>

                <p class="text-gray-500 text-sm">
                    Archived Documents
                </p>
            </div>
        </div>
    </div>

</div>