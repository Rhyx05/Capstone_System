<x-layouts.admin-layout>

<div class="max-w-5xl mx-auto">

    {{-- ================= Single Unified Card: Header + Alerts + Form ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Forward Document</h1>
                    <p class="mt-0.5 text-sm text-gray-500">Send a document directly to a designated employee.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mx-8 mt-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
                <span class="text-lg">✅</span>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mx-8 mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                <p class="font-semibold text-sm mb-1.5">Please correct the following errors:</p>
                <ul class="list-disc list-inside text-sm space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.submit.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="px-8 py-6 space-y-5">

                {{-- Title & Category --}}
                <div class="grid sm:grid-cols-2 gap-5">

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                            Document Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            required
                            autofocus
                            placeholder="Enter document title"
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="category"
                            value="{{ old('category') }}"
                            required
                            placeholder="e.g. Memorandum, Report, Circular"
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                        Description <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Enter document description..."
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                {{-- Send To --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                        Send To <span class="text-red-500">*</span>
                    </label>
                    <select name="sent_to" required class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select personnel</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" @selected(old('sent_to') == $employee->id)>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                                @if($employee->office)
                                    — {{ $employee->office->office_name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- File Upload --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                        Attach File <span class="text-red-500">*</span>
                    </label>

                    <div
                        id="dropzone"
                        class="border-2 border-dashed border-indigo-200 bg-indigo-50/30 rounded-2xl py-8 px-6 text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/60 transition">

                        <div class="mx-auto flex items-center justify-center">
                            <svg class="w-9 h-9 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3" />
                            </svg>
                        </div>

                        <p class="text-sm font-medium text-gray-700 mt-3">
                            Drag & drop your file here, or
                            <span id="browseButton" class="text-indigo-600 hover:text-indigo-700 underline underline-offset-2">browse</span>
                        </p>

                        <input
                            type="file"
                            id="fileInput"
                            name="file"
                            required
                            class="hidden">

                        <p class="text-xs text-gray-400 mt-3">
                            Accepted: PDF, JPG, PNG, DOCX • Max 10MB
                        </p>
                    </div>

                    {{-- Selected file preview --}}
                    <div id="filePreview" class="hidden mt-3 items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3">
                        <div id="fileIconBox" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-500 text-white text-[10px] font-bold">
                            FILE
                        </div>
                        <div class="flex-1 min-w-0">
                            <p id="fileName" class="text-sm font-semibold text-gray-800 truncate"></p>
                            <p id="fileSize" class="text-xs text-gray-500"></p>
                        </div>
                        <span class="text-green-600 text-lg">✓</span>
                        <button type="button" id="removeFile" class="text-gray-400 hover:text-gray-600 text-lg leading-none">&times;</button>
                    </div>

                </div>

            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 px-8 py-5">

                <button
                    type="submit"
                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Forward Document
                </button>
            </div>

        </form>

    </div>

    {{-- ================= Separate Card: Forwarded Documents Table ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-base font-semibold text-gray-900">Forwarded Documents</h2>
            <p class="text-sm text-gray-500 mt-1">Documents you've sent directly to personnel.</p>
        </div>

        <div class="border-t border-gray-100"></div>

        @if($forwardedDocuments->count())

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3.5 text-left">Tracking</th>
                            <th class="px-6 py-3.5 text-left">Title</th>
                            <th class="px-6 py-3.5 text-left">Sent To</th>
                            <th class="px-6 py-3.5 text-center">Status</th>
                            <th class="px-6 py-3.5 text-center">Date Sent</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @php
                            $statusColors = [
                                'for_review' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'approved'   => 'bg-green-50 text-green-700 border-green-200',
                                'assigned'   => 'bg-blue-50 text-blue-700 border-blue-200',
                                'returned'   => 'bg-orange-50 text-orange-700 border-orange-200',
                                'rejected'   => 'bg-red-50 text-red-700 border-red-200',
                                'completed'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            ];
                        @endphp

                        @foreach($forwardedDocuments as $doc)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-semibold text-indigo-700">
                                    {{ $doc->tracking_code }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $doc->title }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $doc->sentTo->first_name }} {{ $doc->sentTo->last_name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$doc->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        {{ ucwords(str_replace('_', ' ', $doc->status)) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center text-gray-500 text-xs">
                                    {{ $doc->submission_date->format('M d, Y') }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

            @if($forwardedDocuments->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $forwardedDocuments->links() }}
                </div>
            @endif

        @else

            <div class="px-8 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 border border-gray-200 text-2xl mb-4">
                    📤
                </div>
                <h2 class="text-base font-semibold text-gray-900">No Documents Forwarded Yet</h2>
                <p class="text-sm text-gray-500 mt-1">Documents you forward will appear here.</p>
            </div>

        @endif

    </div>

</div>

<script>
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');
const browse = document.getElementById('browseButton');
const filePreview = document.getElementById('filePreview');
const fileIconBox = document.getElementById('fileIconBox');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');
const removeFile = document.getElementById('removeFile');

browse.onclick = (e) => { e.stopPropagation(); fileInput.click(); };
dropzone.onclick = () => fileInput.click();

function formatSize(bytes) {
    if (bytes >= 1048576) return (bytes / 1048576).toFixed(2) + ' MB';
    if (bytes >= 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return bytes + ' B';
}

function showFile(file) {
    const ext = file.name.split('.').pop().toUpperCase();
    fileIconBox.textContent = ext.length > 4 ? 'FILE' : ext;
    fileName.textContent = file.name;
    fileSize.textContent = formatSize(file.size);
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
}

fileInput.onchange = () => {
    if (fileInput.files.length) {
        showFile(fileInput.files[0]);
    }
};

removeFile.onclick = (e) => {
    e.stopPropagation();
    fileInput.value = '';
    filePreview.classList.add('hidden');
    filePreview.classList.remove('flex');
};

dropzone.addEventListener('dragover', e => {
    e.preventDefault();
    dropzone.classList.add('border-indigo-500');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('border-indigo-500');
});

dropzone.addEventListener('drop', e => {
    e.preventDefault();
    dropzone.classList.remove('border-indigo-500');
    fileInput.files = e.dataTransfer.files;
    fileInput.dispatchEvent(new Event('change'));
});
</script>

</x-layouts.admin-layout>