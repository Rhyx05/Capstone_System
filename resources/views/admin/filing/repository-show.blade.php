<x-layouts.admin-layout>

<div class="space-y-8">

    {{-- ====================================================== --}}
    {{-- PAGE HEADER --}}
    {{-- ====================================================== --}}

    <div class="flex items-start justify-between">

        <div>

            <a
                href="{{ route('admin.filing.repository', $document->filingCategory) }}"
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700">
       
       ← Back to Repository

            </a>

            <h1 class="mt-5 text-3xl font-bold text-gray-900">

                View Archive Document

            </h1>

            <p class="mt-2 text-gray-500">

               Viewing archived document details.

            </p>

        </div>

        <div>

            @php

                $statusColor = match($document->status){

                    'completed' => 'bg-green-100 text-green-700',

                    'archived' => 'bg-blue-100 text-blue-700',

                    default => 'bg-yellow-100 text-yellow-700'

                };

            @endphp

            <span class="inline-flex rounded-full px-5 py-2 text-sm font-semibold {{ $statusColor }}">

                {{ ucwords(str_replace('_',' ',$document->status)) }}

            </span>

        </div>

    </div>


{{-- ====================================================== --}}
{{-- DOCUMENT DETAILS --}}
{{-- ====================================================== --}}

<div class="overflow-hidden rounded-2xl border bg-white shadow-sm">

    <div class="border-b px-6 py-4">

        <h2 class="text-xl font-bold text-gray-900">

            Document Details

        </h2>

    </div>

    <div class="grid grid-cols-1 gap-x-8 gap-y-5 p-6 md:grid-cols-3">

        {{-- Submitted By --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">

                Submitted By

            </p>

            <p class="mt-1 text-base font-semibold text-gray-900">

                {{ optional($document->submittedBy)->full_name }}

            </p>

        </div>

        {{-- Title --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">

                Title

            </p>

            <p class="mt-1 text-base font-semibold text-gray-900">

                {{ $document->title }}

            </p>

        </div>

        {{-- Submitted Date --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">

                Submitted On

            </p>

            <p class="mt-1 text-base font-semibold text-gray-900">

                {{ optional($document->submission_date)->format('M d, Y h:i A') }}

            </p>

        </div>

        {{-- Office --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">

                Office

            </p>

            <p class="mt-1 text-base text-gray-800">

                {{ optional($document->office)->office_name }}

            </p>

        </div>

        {{-- Category --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">

                Category

            </p>

            <p class="mt-1 text-base text-gray-800">

                {{ $document->category }}

            </p>

        </div>

        {{-- Priority --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">

                Priority

            </p>

            @php

                $priorityColor = match($document->priority){

                    'Urgent' => 'bg-red-100 text-red-700',

                    'High' => 'bg-orange-100 text-orange-700',

                    'Normal' => 'bg-blue-100 text-blue-700',

                    default => 'bg-gray-100 text-gray-700'

                };

            @endphp

            <span class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $priorityColor }}">

                {{ $document->priority }}

            </span>

        </div>

        {{-- Tracking Code --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">

                Tracking Code

            </p>

            <p class="mt-1 font-semibold text-blue-700">

                {{ $document->tracking_code }}

            </p>

        </div>

        {{-- File Type --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">

                File Type

            </p>

            <p class="mt-1 text-base text-gray-800">

                {{ strtoupper($document->file_type) }}

            </p>

        </div>

        {{-- File Size --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">

                File Size

            </p>

            <p class="mt-1 text-base text-gray-800">

                {{ number_format($document->file_size / 1024 / 1024, 2) }} MB

            </p>

        </div>

    </div>

</div>

<div class="grid grid-cols-12 gap-6">

    {{-- ===================================================== --}}
    {{-- OCR / FILE PREVIEW --}}
    {{-- ===================================================== --}}
    <div class="col-span-12 xl:col-span-8">

        <div class="bg-white rounded-2xl border shadow-sm">

            <div class="border-b px-6 py-5 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold">OCR Extracted Text</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ $document->file_name }}</p>
                </div>

                <a href="{{ asset('storage/'.$document->file_path) }}" download class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V4m0 12l-4-4m4 4l4-4M4 20h16"/>
                    </svg>
                    Download Original
                </a>
            </div>

            <div class="p-6">

                @if(Str::contains(strtolower($document->file_type), 'pdf'))

                    <iframe src="{{ asset('storage/'.$document->file_path) }}" class="h-[900px] w-full rounded-xl border"></iframe>

                @elseif(Str::contains(strtolower($document->file_type), 'image'))

                    <img src="{{ asset('storage/'.$document->file_path) }}" class="w-full rounded-xl border">

                @else

                    <div class="rounded-xl border bg-gray-50 p-6 max-h-[700px] overflow-y-auto whitespace-pre-wrap text-sm leading-7">
                        {{ $document->extracted_text ?: 'No extracted content available for this file.' }}
                    </div>

                @endif

            </div>

        </div>

    </div>

{{-- ===================================================== --}}
    {{-- DOCUMENT TIMELINE --}}
    {{-- ===================================================== --}}
    <div class="col-span-12 xl:col-span-4">

        <div class="sticky top-6 bg-white rounded-2xl border shadow-sm overflow-hidden">

            <div class="border-b px-6 py-5">
                <h2 class="text-xl font-bold">Document Timeline</h2>
            </div>

            <div class="p-6">

                <div class="space-y-0">

                    {{-- Submitted --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-600 text-xs text-white">✓</span>
                            <span class="w-0.5 flex-1 bg-blue-200"></span>
                        </div>
                        <div class="pb-8">
                            <h3 class="font-semibold">Submitted</h3>
                            <p class="text-sm text-gray-600">{{ optional($document->submittedBy)->full_name }}</p>
                            <p class="text-xs text-gray-400">{{ optional($document->submission_date)?->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    {{-- Reviewed --}}
                    @if($document->reviewed_at)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-yellow-500 text-xs text-white">✓</span>
                            <span class="w-0.5 flex-1 bg-blue-200"></span>
                        </div>
                        <div class="pb-8">
                            <h3 class="font-semibold">Reviewed</h3>
                            <p class="text-sm text-gray-600">{{ optional($document->reviewer)->full_name ?? 'Administrator' }}</p>
                            <p class="text-xs text-gray-400">{{ $document->reviewed_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Approved --}}
                    @if($document->approved_at)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-600 text-xs text-white">✓</span>
                            <span class="w-0.5 flex-1 bg-blue-200"></span>
                        </div>
                        <div class="pb-8">
                            <h3 class="font-semibold">Approved</h3>
                            <p class="text-sm text-gray-600">{{ optional($document->approver)->full_name ?? 'Administrator' }}</p>
                            <p class="text-xs text-gray-400">{{ $document->approved_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Assigned --}}
                    @if($document->assigned_at)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-xs text-white">✓</span>
                            <span class="w-0.5 flex-1 bg-blue-200"></span>
                        </div>
                        <div class="pb-8">
                            <h3 class="font-semibold">Assigned</h3>
                            <p class="text-sm text-gray-600">{{ optional($document->assignedUser)->full_name }}</p>
                            <p class="text-xs text-gray-400">{{ $document->assigned_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Completed --}}
                    @if($document->status == 'completed' || $document->status == 'archived')
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs text-white">✓</span>
                        </div>
                        <div>
                            <h3 class="font-semibold">Completed</h3>
                            <p class="text-sm text-gray-600">Workflow completed successfully.</p>
                            <p class="text-xs text-gray-400">{{ $document->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

</x-layouts.admin-layout>