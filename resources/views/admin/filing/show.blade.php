<x-layouts.admin-layout>

<div class="max-w-6xl mx-auto">

@php
    $statusColor = match($document->status){
        'completed' => 'bg-green-50 text-green-700 border-green-200',
        'archived'  => 'bg-blue-50 text-blue-700 border-blue-200',
        default     => 'bg-yellow-50 text-yellow-700 border-yellow-200',
    };
    $priorityColors = [
        'Low'    => 'bg-green-500',
        'Normal' => 'bg-blue-500',
        'High'   => 'bg-orange-500',
        'Urgent' => 'bg-red-500',
    ];
@endphp

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Archive Document</h1>
                        <p class="mt-0.5 text-sm text-gray-500">Review the document details before assigning it to a repository.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">

                    <span class="px-4 py-2 rounded-full text-xs font-semibold border {{ $statusColor }}">
                        {{ ucwords(str_replace('_', ' ', $document->status)) }}
                    </span>

                    <a
                        href="{{ route('admin.filing.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:border-indigo-200 hover:text-indigo-600 transition">
                        <span>←</span> Back
                    </a>

                </div>

            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- ===================================================== --}}
        {{-- DOCUMENT DETAILS --}}
        {{-- ===================================================== --}}
        <div class="px-8 py-6">

            <div class="flex items-center gap-2 mb-5">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-sm">📄</span>
                <h2 class="text-base font-semibold text-gray-900">Document Details</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Submitted By</p>
                    <p class="text-sm font-semibold text-gray-800">{{ optional($document->submittedBy)->full_name }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Title</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $document->title }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Submitted On</p>
                    <p class="text-sm font-semibold text-gray-800">{{ optional($document->submission_date)->format('M d, Y h:i A') }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Office</p>
                    <p class="text-sm font-semibold text-gray-800">{{ optional($document->office)->office_name }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Category</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $document->category }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Priority</p>
                    <p class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full {{ $priorityColors[$document->priority] ?? 'bg-gray-400' }}"></span>
                        {{ $document->priority }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Tracking Code</p>
                    <p class="text-sm font-semibold text-indigo-700">{{ $document->tracking_code }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">File Type</p>
                    <p class="text-sm font-semibold text-gray-800">{{ strtoupper($document->file_type) }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">File Size</p>
                    <p class="text-sm font-semibold text-gray-800">{{ number_format($document->file_size / 1024 / 1024, 2) }} MB</p>
                </div>

            </div>
        </div>

        <div class="border-t border-gray-400"></div>

        {{-- ===================================================== --}}
        {{-- DOCUMENT PREVIEW --}}
        {{-- ===================================================== --}}
        <div class="px-8 py-6">

            <div class="flex items-center gap-2 mb-1">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">🔍</span>
                <h2 class="text-base font-semibold text-gray-900">OCR Extracted Text</h2>
            </div>
            <p class="text-sm text-gray-500 mb-5 ml-9">{{ $document->file_name }}</p>

            @if(Str::contains(strtolower($document->file_type), 'pdf'))

                <iframe
                    src="{{ asset('storage/'.$document->file_path) }}"
                    class="w-full h-[700px] rounded-xl border border-gray-200">
                </iframe>

            @else

                <div class="rounded-xl border border-gray-200 bg-gray-50 p-6 max-h-[700px] overflow-y-auto whitespace-pre-wrap text-sm text-gray-700 leading-7">
                    {{ $document->extracted_text ?: 'No extracted content available for this file.' }}
                </div>

            @endif

        </div>

        <div class="border-t border-gray-400"></div>

    {{-- ===================================================== --}}
{{-- ARCHIVE --}}
{{-- ===================================================== --}}
<div class="px-8 py-8">

    <div class="max-w-md mx-auto">


        <form
            method="POST"
            action="{{ route('admin.filing.documents.archive', $document) }}">

            @csrf

            {{-- Repository Row --}}
            <div class="flex items-center gap-4 mb-5">

                <label
                    for="filing_category_id"
                    class="w-28 text-sm font-semibold text-gray-700">
                    Repository
                </label>

                <select
                    id="filing_category_id"
                    name="filing_category_id"
                    required
                    class="flex-1 rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <option value="">Select Repository</option>

                    @foreach($repositories as $repository)
                        <option value="{{ $repository->id }}">
                            {{ $repository->icon }} {{ $repository->name }}
                        </option>
                    @endforeach

                </select>

            </div>

            {{-- Archive Button --}}
            <button
                type="submit"
                class="w-full flex items-center justify-center gap-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 py-3 text-white text-sm font-semibold transition">

                📦 Archive Document

            </button>

        </form>

    </div>

</div>

</div>

</x-layouts.admin-layout>