<div
    id="deleteRepositoryModal"
    class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4">

    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="px-6 py-5 border-b">

            <h2 class="text-xl font-bold text-red-600">

                Delete Repository

            </h2>

        </div>

        {{-- Body --}}
        <div class="p-6">

            <div class="flex justify-center mb-5">

                <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center text-4xl">

                    🗑

                </div>

            </div>

            <h3
                class="text-center text-lg font-semibold">

                Delete this Repository?

            </h3>

            <p
                class="text-center text-gray-500 mt-3">

                This action cannot be undone.

            </p>

            <p
                class="text-center mt-3">

                Repository:

                <strong id="deleteRepositoryName"></strong>

            </p>

            <p
                class="text-center text-sm text-red-500 mt-4">

                Repositories containing archived documents
                cannot be deleted.

            </p>

        </div>

        {{-- Footer --}}
        <div class="flex justify-end gap-3 border-t px-6 py-5">

            <button
                type="button"
                onclick="closeDeleteCategoryModal()"
                class="rounded-xl border px-5 py-2 hover:bg-gray-100">

                Cancel

            </button>

            <form
                id="deleteForm"
                method="POST">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="rounded-xl bg-red-600 px-6 py-2 text-white hover:bg-red-700">

                    Delete Repository

                </button>

            </form>

        </div>

    </div>

</div>