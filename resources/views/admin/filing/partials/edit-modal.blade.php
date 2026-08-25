{{-- ========================================================= --}}
{{-- EDIT REPOSITORY MODAL --}}
{{-- ========================================================= --}}

<div
    id="editRepositoryModal"
    class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg">

        {{-- Header --}}
        <div class="border-b px-6 py-4 flex items-center justify-between">

            <h2 class="text-xl font-bold">
                Edit Repository
            </h2>

            <button
                type="button"
                onclick="closeEditCategoryModal()"
                class="text-gray-500 hover:text-red-500 text-xl">

                ✕

            </button>

        </div>

        {{-- Form --}}
        <form
            id="editForm"
            method="POST">

            @csrf
            @method('PUT')

            <div class="p-6 space-y-5">

                {{-- Repository Name --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Repository Name
                    </label>

                    <input
                        id="edit-name"
                        type="text"
                        name="name"
                        required
                        class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                </div>

                {{-- Description --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Description
                    </label>

                    <textarea
                        id="edit-description"
                        name="description"
                        rows="3"
                        class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>

                </div>

                {{-- Repository Icon --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Repository Icon
                    </label>

                    <select
                        id="edit-icon"
                        name="icon"
                        required
                        class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        <option value="📁">📁 Folder</option>
                        <option value="📂">📂 Open Folder</option>
                        <option value="🗂️">🗂️ Cabinet</option>
                        <option value="📄">📄 Documents</option>
                        <option value="📝">📝 Records</option>
                        <option value="📚">📚 Books</option>
                        <option value="🗃️">🗃️ Archive Box</option>

                    </select>

                </div>

                {{-- Repository Color --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Repository Color
                    </label>

                    <select
                        id="edit-color"
                        name="color"
                        required
                        class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        <option value="indigo">Indigo</option>
                        <option value="blue">Blue</option>
                        <option value="green">Green</option>
                        <option value="yellow">Yellow</option>
                        <option value="orange">Orange</option>
                        <option value="red">Red</option>
                        <option value="purple">Purple</option>

                    </select>

                </div>

            </div>

            {{-- Footer --}}
            <div class="border-t px-6 py-4 flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeEditCategoryModal()"
                    class="px-5 py-2 rounded-xl border border-gray-300 hover:bg-gray-50">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="px-5 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition">

                    Save Changes

                </button>

            </div>

        </form>

    </div>

</div>