<div
    id="archiveDocumentModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">

        <div class="border-b px-6 py-5">

            <h2 class="text-2xl font-bold text-blue-600">

                📦 Archive Document

            </h2>

            <p class="mt-2 text-sm text-gray-500">

                Choose the repository where this completed document will be stored.

            </p>

        </div>

        <form
            id="archiveDocumentForm"
            method="POST">

            @csrf

            <div class="p-6 space-y-5">

                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Repository

                    </label>

                    <select
                        name="filing_category_id"
                        required
                        class="w-full rounded-xl border-gray-300">

                        <option value="">

                            Select Repository

                        </option>

                        @foreach($repositories as $repository)

                            <option value="{{ $repository->id }}">

                                {{ $repository->icon }}
                                {{ $repository->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex justify-end gap-3 border-t px-6 py-5">

                <button
                    type="button"
                    onclick="closeArchiveDocumentModal()"
                    class="rounded-xl border border-gray-300 px-5 py-2 hover:bg-gray-100">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-2 font-semibold text-white hover:bg-blue-700">

                    📦 Archive

                </button>

            </div>

        </form>

    </div>

</div>