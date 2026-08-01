<div
    x-show="open"
    x-cloak
    class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-6">

    <div
        @click.away="open=false"
        class="bg-white rounded-2xl shadow-xl w-full max-w-6xl max-h-[95vh] overflow-y-auto">

        <div class="flex justify-between items-center border-b px-8 py-6">

            <div>

                <h2 class="text-2xl font-bold">

                    Incoming Document

                </h2>

                <p class="text-gray-500 mt-1">

                    Tracking Code:
                    <span
                        class="font-semibold"
                        x-text="selected.tracking_code">
                    </span>

                </p>

            </div>

            <button

                @click="open=false"

                class="text-gray-500 hover:text-black text-3xl">

                &times;

            </button>

        </div>

        <div class="grid grid-cols-3 gap-8 p-8">

            <div class="col-span-2 space-y-6">

                <div class="bg-gray-50 rounded-xl p-6">

                    <h3 class="font-bold text-lg mb-5">

                        Document Information

                    </h3>

                    <div class="grid grid-cols-2 gap-5">

                        <div>

                            <label class="text-gray-500">

                                Title

                            </label>

                            <p class="font-semibold"
                               x-text="selected.title">
                            </p>

                        </div>

                        <div>

                            <label class="text-gray-500">

                                Category

                            </label>

                            <p x-text="selected.category"></p>

                        </div>

                        <div>

                            <label class="text-gray-500">

                                Priority

                            </label>

                            <p x-text="selected.priority"></p>

                        </div>

                        <div>

                            <label class="text-gray-500">

                                Status

                            </label>

                            <p
                                class="font-semibold"
                                x-text="selected.status">
                            </p>

                        </div>

                    </div>

                </div>

                <div class="bg-gray-50 rounded-xl p-6">

                    <h3 class="font-bold mb-4">

                        Description

                    </h3>

                    <p
                        class="whitespace-pre-wrap"
                        x-text="selected.description">
                    </p>

                </div>

                <div class="bg-gray-50 rounded-xl p-6">

                    <h3 class="font-bold mb-4">

                        OCR Extracted Text

                    </h3>

                    <div
                        class="max-h-96 overflow-y-auto border rounded-lg p-4 whitespace-pre-wrap bg-white"
                        x-text="selected.extracted_text || 'No OCR text available.'">

                    </div>

                </div>

            </div>

            <div class="space-y-6">

                <div class="bg-gray-50 rounded-xl p-6">

                    <h3 class="font-bold mb-5">

                        Assignment Information

                    </h3>

                    <div class="space-y-4">

                        <div>

                            <label class="text-gray-500">

                                Assigned Date

                            </label>

                            <p
                                x-text="selected.assigned_at">
                            </p>

                        </div>

                        <div>

                            <label class="text-gray-500">

                                Remarks

                            </label>

                            <p
                                class="whitespace-pre-wrap"
                                x-text="selected.remarks || 'No remarks.'">
                            </p>

                        </div>

                    </div>

                </div>

                <div class="bg-gray-50 rounded-xl p-6">

                    <h3 class="font-bold mb-4">

                        Timeline

                    </h3>

                    <template
                        x-if="selected.logs && selected.logs.length">

                        <template
                            x-for="log in selected.logs">

                            <div class="border-l-4 border-blue-600 pl-4 mb-5">

                                <div
                                    class="font-semibold"
                                    x-text="log.action">
                                </div>

                                <div
                                    class="text-sm text-gray-500"
                                    x-text="log.remarks">
                                </div>

                            </div>

                        </template>

                    </template>

                    <template
                        x-if="!selected.logs || selected.logs.length===0">

                        <p class="text-gray-500">

                            No history available.

                        </p>

                    </template>

                </div>

                <button

                    @click="open=false"

                    class="w-full bg-gray-800 hover:bg-gray-900 text-white py-3 rounded-lg">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>