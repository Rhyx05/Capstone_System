<x-layouts.employee-layout>

@if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
        <span class="text-lg">✅</span>
        <div>
            <p class="font-semibold text-sm">Success</p>
            <p class="text-sm text-green-700 mt-0.5">{{ session('success') }}</p>
        </div>
    </div>
@endif

<div class="max-w-5xl mx-auto">
    
    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <p class="font-semibold text-sm mb-1.5">Please correct the following errors:</p>
            <ul class="list-disc list-inside text-sm space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.submit.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ================= Single Unified Card ================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Header --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Submit New Document</h1>
                        <p class="mt-0.5 text-sm text-gray-500">Upload your document for administrator review and routing.</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Body: two columns --}}
            <div class="grid md:grid-cols-2 gap-8 p-8">

                {{-- LEFT COLUMN --}}
                <div class="space-y-6">

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                            Document Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            required
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Enter document title">
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="category"
                            value="{{ old('category') }}"
                            required
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ex: Memorandum, Request Letter, Report">
                    </div>

                    {{-- Priority --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Priority Level <span class="text-red-500">*</span>
                        </label>

                        <div class="grid grid-cols-4 gap-2" id="priorityGroup">
                            @php
                                $priorityStyles = [
                                    'Low'    => ['dot' => 'bg-green-500',  'ring' => 'border-green-200'],
                                    'Normal' => ['dot' => 'bg-blue-500',   'ring' => 'border-blue-200'],
                                    'High'   => ['dot' => 'bg-orange-500', 'ring' => 'border-orange-200'],
                                    'Urgent' => ['dot' => 'bg-red-500',    'ring' => 'border-red-200'],
                                ];
                            @endphp

                            @foreach(['Low','Normal','High','Urgent'] as $priority)
                                <label class="priority-option relative flex items-center justify-center gap-1.5 rounded-xl border-2 border-gray-200 py-2.5 text-xs font-medium text-gray-600 cursor-pointer hover:border-gray-300 transition">
                                    <input
                                        type="radio"
                                        name="priority"
                                        value="{{ $priority }}"
                                        {{ old('priority','Normal')==$priority?'checked':'' }}
                                        class="peer hidden">

                                    <span class="h-2 w-2 rounded-full {{ $priorityStyles[$priority]['dot'] }}"></span>
                                    <span>{{ $priority }}</span>

                                    <span class="selected-check hidden absolute -top-1.5 -right-1.5 h-4 w-4 rounded-full bg-blue-600 text-white items-center justify-center text-[9px]">✓</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                            Description
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            rows="6"
                            maxlength="500"
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Enter document description...">{{ old('description') }}</textarea>
                        <p class="text-right text-xs text-gray-400 mt-1">
                            <span id="charCount">0</span>/500
                        </p>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="space-y-4">

                    <label class="block text-sm font-semibold text-gray-800">
                        Upload Document <span class="text-red-500">*</span>
                    </label>

                    <div
                        id="dropzone"
                        class="border-2 border-dashed border-indigo-200 bg-indigo-50/30 rounded-2xl py-10 px-6 text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/60 transition">

                        <div id="uploadIcon" class="mx-auto flex items-center justify-center">
                            <svg class="w-10 h-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3" />
                            </svg>
                        </div>

                        <p class="text-base font-medium text-gray-700 mt-4">
                            Drag & drop your document here
                        </p>

                        <p class="text-sm text-gray-400 mt-1">or</p>

                        <button
                            type="button"
                            id="browseButton"
                            class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                            Browse Files
                        </button>

                        <input
                            type="file"
                            id="document"
                            name="document"
                            accept=".pdf,.doc,.docx"
                            class="hidden">

                        <p class="text-xs text-gray-400 mt-4">
                            PDF, DOC, DOCX up to 10MB
                        </p>
                    </div>

                    {{-- Selected file preview --}}
                    <div id="filePreview" class="hidden items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-500 text-white text-[10px] font-bold">
                            PDF
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

            {{-- Footer --}}
            <div class="flex items-center justify-center gap-2 px-8 py-5">
                <button
                    type="submit"
                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Submit Document
                </button>
            </div>

        </div>

    </form>

</div>

<script>
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('document');
const browse = document.getElementById('browseButton');
const filePreview = document.getElementById('filePreview');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');
const removeFile = document.getElementById('removeFile');
const description = document.getElementById('description');
const charCount = document.getElementById('charCount');

browse.onclick = (e) => { e.stopPropagation(); fileInput.click(); };
dropzone.onclick = () => fileInput.click();

function formatSize(bytes) {
    if (bytes >= 1048576) return (bytes / 1048576).toFixed(2) + ' MB';
    if (bytes >= 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return bytes + ' B';
}

function showFile(file) {
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

// Description character counter
description.addEventListener('input', () => {
    charCount.textContent = description.value.length;
});
charCount.textContent = description.value.length;

// Priority selection styling
document.querySelectorAll('.priority-option').forEach(option => {
    const input = option.querySelector('input[type="radio"]');
    const check = option.querySelector('.selected-check');

    function refresh() {
        document.querySelectorAll('.priority-option').forEach(opt => {
            opt.classList.remove('border-blue-500', 'bg-blue-50', 'text-blue-600', 'font-semibold');
            opt.querySelector('.selected-check').classList.add('hidden');
            opt.querySelector('.selected-check').classList.remove('flex');
        });
        if (input.checked) {
            option.classList.add('border-blue-500', 'bg-blue-50', 'text-blue-600', 'font-semibold');
            check.classList.remove('hidden');
            check.classList.add('flex');
        }
    }

    input.addEventListener('change', refresh);
    if (input.checked) refresh();
});
</script>

</x-layouts.employee-layout>