<div
    id="editRepositoryModal"
    class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b px-6 py-5">

            <h2 class="text-xl font-bold">

                Edit Repository

            </h2>

            <button
                onclick="closeEditCategoryModal()"
                class="text-gray-500 hover:text-red-600 text-xl">

                ✕

            </button>

        </div>

        {{-- Form --}}
        <form
            id="editForm"
            method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-5 p-6">

                {{-- Name --}}
                <div>

                    <label class="block mb-2 font-semibold">

                        Repository Name

                    </label>

                    <input
                        id="edit-name"
                        name="name"
                        type="text"
                        required
                        class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                </div>

                {{-- Description --}}
                <div>

                    <label class="block mb-2 font-semibold">

                        Description

                    </label>

                    <textarea
                        id="edit-description"
                        name="description"
                        rows="3"
                        class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>

                </div>

                <div class="grid grid-cols-2 gap-4">

                    {{-- Icon --}}
                    <div>

                        <label class="block mb-2 font-semibold">

                            Icon

                        </label>

                        <input
                            id="edit-icon"
                            name="icon"
                            type="text"
                            maxlength="10"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    {{-- Color --}}
                    <div>

                        <label class="block mb-2 font-semibold">

                            Color

                        </label>

                        <select
                            id="edit-color"
                            name="color"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="red">Red</option>
                            <option value="yellow">Yellow</option>
                            <option value="purple">Purple</option>
                            <option value="gray">Gray</option>

                        </select>

                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 border-t px-6 py-5">

                <button
                    type="button"
                    onclick="closeEditCategoryModal()"
                    class="rounded-xl border px-5 py-2 hover:bg-gray-100">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">

                    Save Changes

                </button>

            </div>

        </form>

    </div>

</div>