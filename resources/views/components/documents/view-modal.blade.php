<div
    x-show="open"
    x-transition
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    style="display:none">

    <div class="bg-white rounded-xl shadow-xl w-11/12 max-w-6xl max-h-[90vh] overflow-y-auto">

        <div class="flex justify-between items-center border-b p-6">

            <div>

                <h2 class="text-2xl font-bold">

                    Document Details

                </h2>

                <p class="text-gray-500">

                    Tracking Code:

                    <span
                        class="font-semibold"
                        x-text="selected.tracking_code"></span>

                </p>

            </div>

            <button
                @click="open=false"
                class="text-2xl">

                ✕

            </button>

        </div>

        <div class="grid grid-cols-2 gap-8 p-8">

            <div>

                <div class="space-y-4">

                    <div>

                        <label class="font-semibold">

                            Title

                        </label>

                        <p x-text="selected.title"></p>

                    </div>

                    <div>

                        <label class="font-semibold">

                            Category

                        </label>

                        <p x-text="selected.category"></p>

                    </div>

                    <div>

                        <label class="font-semibold">

                            Priority

                        </label>

                        <p x-text="selected.priority"></p>

                    </div>

                    <div>

                        <label class="font-semibold">

                            Status

                        </label>

                        <p x-text="selected.status"></p>

                    </div>

                    <div>

                        <label class="font-semibold">

                            Description

                        </label>

                        <p x-text="selected.description"></p>

                    </div>

                    <div>

                        <label class="font-semibold">

                            Administrator Remarks

                        </label>

                        <p x-text="selected.remarks ?? 'No remarks yet.'"></p>

                    </div>

                </div>

            </div>

            <div>

                <template x-if="selected.file_type=='pdf'">

                    <iframe

                        :src="'/storage/'+selected.file_path"

                        class="w-full h-[600px] border rounded-lg">

                    </iframe>

                </template>

                <template x-if="selected.file_type!='pdf'">

                    <div
                        class="border rounded-lg p-5 h-[600px] overflow-y-auto whitespace-pre-wrap">

                        <pre x-text="selected.extracted_text"></pre>

                    </div>

                </template>

            </div>

        </div>

        <div class="border-t p-6 flex justify-end gap-3">

            <a

                :href="'/storage/'+selected.file_path"

                download

                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">

                Download

            </a>

            <button

                @click="open=false"

                class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg">

                Close

            </button>

        </div>

    </div>

</div>