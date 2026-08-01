{{-- ========================================================= --}}
{{-- CREATE REPOSITORY MODAL --}}
{{-- ========================================================= --}}

<div
    id="createRepositoryModal"
    class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg">

        <div class="border-b px-6 py-4 flex items-center justify-between">

            <h2 class="text-xl font-bold">
                Create Repository
            </h2>

            <button
                onclick="closeCreateCategoryModal()"
                class="text-gray-500 hover:text-red-500 text-xl">

                ✕

            </button>

        </div>

        <form
            action="{{ route('admin.filing.store') }}"
            method="POST">

            @csrf

            <div class="p-6 space-y-5">

                <div>

                    <label class="block mb-2 font-medium">

                        Repository Name

                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        class="w-full rounded-xl border-gray-300">

                </div>

                <div>

                    <label class="block mb-2 font-medium">

                        Description

                    </label>

                    <textarea
                        name="description"
                        rows="3"
                        class="w-full rounded-xl border-gray-300"></textarea>

                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>

                        <label class="block mb-2 font-medium">

                            Icon

                        </label>

                        <input
                            type="text"
                            name="icon"
                            value="📁"
                            maxlength="5"
                            class="w-full rounded-xl border-gray-300">

                    </div>

                    <div>

                        <label class="block mb-2 font-medium">

                            Color

                        </label>

                        <select
                            name="color"
                            class="w-full rounded-xl border-gray-300">

                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="red">Red</option>
                            <option value="yellow">Yellow</option>
                            <option value="purple">Purple</option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="border-t px-6 py-4 flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeCreateCategoryModal()"
                    class="px-5 py-2 rounded-xl border">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="px-5 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700">

                    Create Repository

                </button>

            </div>

        </form>

    </div>

</div>