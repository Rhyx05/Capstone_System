<x-layouts.employee-layout>
@if(session('success'))

    <div class="mb-6 rounded-xl border border-green-300 bg-green-100 px-6 py-4 text-green-700">

        <div class="font-semibold">
            ✅ Success
        </div>

        <div class="mt-1">
            {{ session('success') }}
        </div>

    </div>

@endif
<div class="max-w-5xl mx-auto">


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-300 bg-red-100 px-6 py-4 text-red-700">

            <div class="font-semibold mb-2">
                Please correct the following errors:
            </div>

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold">

            Submit New Document

        </h1>

        <p class="mt-2 text-gray-500">

            Upload your document for administrator review and routing.

        </p>

    </div>

    <form
        action="{{ route('user.submit.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-8">

        @csrf

        {{-- ================= Document Information ================= --}}
        <div class="bg-white rounded-2xl shadow border p-8">

            <h2 class="text-xl font-bold mb-6">

                Document Information

            </h2>

            {{-- Title --}}
            <div>

                <label class="block font-medium mb-2">

                    Title

                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full rounded-xl border-gray-300"
                    placeholder="Enter document title">

            </div>

            {{-- Category & Priority --}}
            <div class="grid md:grid-cols-2 gap-6 mt-6">

                <div>

                    <label class="block font-medium mb-2">

                        Category

                    </label>

                    <input
                        type="text"
                        name="category"
                        value="{{ old('category') }}"
                        class="w-full rounded-xl border-gray-300"
                        placeholder="Ex: Memorandum">

                </div>

                <div>

                    <label class="block font-medium mb-3">

                        Priority

                    </label>

                    <div class="flex flex-wrap gap-4">

                        @foreach(['Low','Normal','High','Urgent'] as $priority)

                            <label class="flex items-center gap-2 cursor-pointer">

                                <input
                                    type="radio"
                                    name="priority"
                                    value="{{ $priority }}"
                                    {{ old('priority','Normal')==$priority?'checked':'' }}>

                                <span>{{ $priority }}</span>

                            </label>

                        @endforeach

                    </div>

                </div>

            </div>

            {{-- Description --}}
            <div class="mt-6">

                <label class="block font-medium mb-2">

                    Description

                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="w-full rounded-xl border-gray-300"
                    placeholder="Enter document description...">{{ old('description') }}</textarea>

            </div>

        </div>

        {{-- ================= Upload ================= --}}
        <div class="bg-white rounded-2xl shadow border p-8">

            <h2 class="text-xl font-bold mb-6">

                Upload Document

            </h2>

            <div
                id="dropzone"
                class="border-2 border-dashed border-gray-300 rounded-2xl p-12 text-center cursor-pointer hover:border-blue-500 transition">

                <div
                    id="uploadIcon"
                    class="text-6xl">

                    📄

                </div>

                <h3 class="text-xl font-semibold mt-5">

                    Drag & Drop your document here

                </h3>

                <p class="text-gray-500 mt-2">

                    or click below to browse

                </p>

                <button
                    type="button"
                    id="browseButton"
                    class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl">

                    Browse Files

                </button>

                <input
                    type="file"
                    id="document"
                    name="document"
                    accept=".pdf,.doc,.docx"
                    class="hidden">

                <p
                    id="selectedFile"
                    class="mt-6 text-gray-600 font-medium">

                    No file selected

                </p>

                <p class="text-sm text-gray-400 mt-3">

                    Accepted formats: PDF, DOC, DOCX • Maximum size: 10 MB

                </p>

            </div>

        </div>

        {{-- Submit --}}
        <button
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl text-lg font-semibold transition">

            Submit Document

        </button>

    </form>

</div>

<script>

const dropzone=document.getElementById('dropzone');
const fileInput=document.getElementById('document');
const browse=document.getElementById('browseButton');
const selected=document.getElementById('selectedFile');
const icon=document.getElementById('uploadIcon');

browse.onclick=()=>fileInput.click();

dropzone.onclick=()=>fileInput.click();

fileInput.onchange=()=>{

    if(fileInput.files.length){

        selected.innerHTML='📄 '+fileInput.files[0].name;

        icon.innerHTML='✅';

    }

};

dropzone.addEventListener('dragover',e=>{

    e.preventDefault();

    dropzone.classList.add('border-blue-500');

});

dropzone.addEventListener('dragleave',()=>{

    dropzone.classList.remove('border-blue-500');

});

dropzone.addEventListener('drop',e=>{

    e.preventDefault();

    dropzone.classList.remove('border-blue-500');

    fileInput.files=e.dataTransfer.files;

    fileInput.dispatchEvent(new Event('change'));

});

</script>

</x-layouts.employee-layout>