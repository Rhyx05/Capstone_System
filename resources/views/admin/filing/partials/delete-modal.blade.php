<div id="deleteRepositoryModal"
    class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6"
        onclick="event.stopPropagation()">

        <h2 class="text-xl font-bold text-gray-800 mb-3">
            Delete Repository
        </h2>

        <p class="text-gray-600 mb-6">
            Are you sure you want to delete
            <strong id="delete-repository-name"></strong>?
            This action cannot be undone.
        </p>

        <form id="deleteRepositoryForm" method="POST" action="">
            @csrf
            @method('DELETE')

            <div class="flex justify-end gap-3">
                <button type="button"
                    onclick="closeDeleteRepositoryModal()"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cancel
                </button>

                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                    Delete Repository
                </button>
            </div>
        </form>
    </div>
</div>