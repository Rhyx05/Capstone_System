<x-layouts.employee-layout>

    {{-- ===================================================== --}}
    {{-- PAGE HEADER --}}
    {{-- ===================================================== --}}

    <div class="grid grid-cols-3 items-center mb-8">

        {{-- Left --}}
        <div>

            <h1 class="text-2xl font-bold text-gray-900">
                Document Details
            </h1>

            <p class="mt-1 text-gray-500">
                Tracking Code
                <span class="font-semibold text-blue-700">
                    {{ $document->tracking_code }}
                </span>
            </p>

        </div>

        {{-- Center --}}
        <div class="flex justify-center">

            <span class="px-5 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-700">
                {{ ucwords(str_replace('_',' ',$document->status)) }}
            </span>

        </div>

        {{-- Right --}}
        <div class="flex justify-end">

            <a
                href="{{ route('user.documents') }}"
                class="w-16 h-16 rounded-xl border border-gray-200 bg-white hover:bg-gray-100 hover:border-blue-300 hover:text-blue-600 flex flex-col items-center justify-center transition">

                <span class="text-2xl leading-none">←</span>
                <span class="text-xs font-medium mt-1">Back</span>

            </a>

        </div>

    </div>

    {{-- ===================================================== --}}
    {{-- DOCUMENT INFORMATION --}}
    {{-- ===================================================== --}}

    <div class="bg-white rounded-2xl border shadow-sm mb-6">

        <div class="px-6 py-5 border-b">
            <h2 class="text-xl font-bold">Document Information</h2>
        </div>

        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>
                    <p class="text-xs uppercase text-gray-500 tracking-wide">Title</p>
                    <p class="font-semibold mt-2">{{ $document->title }}</p>
                </div>

                <div>
                    <p class="text-xs uppercase text-gray-500 tracking-wide">Category</p>
                    <p class="font-semibold mt-2">{{ $document->category }}</p>
                </div>

                <div>
                    <p class="text-xs uppercase text-gray-500 tracking-wide">Priority</p>
                    <p class="font-semibold mt-2">{{ $document->priority }}</p>
                </div>

                <div>
                    <p class="text-xs uppercase text-gray-500 tracking-wide">Submitted</p>
                    <p class="font-semibold mt-2">{{ $document->submission_date->format('F d, Y h:i A') }}</p>
                </div>

                <div>
                    <p class="text-xs uppercase text-gray-500 tracking-wide">Office</p>
                    <p class="font-semibold mt-2">{{ $document->office->office_name ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs uppercase text-gray-500 tracking-wide">Description</p>
                    <p class="font-semibold mt-2">{{ $document->description ?: 'No description provided.' }}</p>
                </div>

            </div>

        </div>

    </div>

    {{-- ===================================================== --}}
    {{-- PREVIEW + SIDEBAR --}}
    {{-- ===================================================== --}}

    <div class="grid grid-cols-12 gap-6">

        {{-- DOCUMENT PREVIEW --}}
        <div class="col-span-12 xl:col-span-8">

            <div class="bg-white rounded-2xl border shadow-sm">

                <div class="border-b px-6 py-5 flex items-center justify-between">

                    <h2 class="text-xl font-bold">OCR Extracted Text</h2>

                </div>

                <div class="p-6">

                    @if($document->file_type == 'pdf')

                        <iframe
                            src="{{ asset('storage/'.$document->file_path) }}"
                            class="w-full h-[700px] rounded-xl border">
                        </iframe>

                    @else

                        <div class="rounded-xl border bg-gray-50 p-6 max-h-[700px] overflow-y-auto whitespace-pre-wrap text-sm leading-7">
                            {{ $document->extracted_text ?: 'No extracted text available.' }}
                        </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- SIDEBAR: REMARKS + TIMELINE --}}
        <div class="col-span-12 xl:col-span-4">

            <div class="sticky top-6 space-y-6">

                {{-- Administrator Remarks --}}
                <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

                    <div class="border-b px-6 py-5">
                        <h2 class="text-xl font-bold"> Remarks</h2>
                    </div>

                    <div class="p-6">
                        <p class="text-gray-700">{{ $document->remarks ?: 'No remarks yet.' }}</p>
                    </div>

                </div>

{{-- ===================================================== --}}
{{-- DOCUMENT TIMELINE --}}
{{-- ===================================================== --}}
<div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

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
                    <p class="text-sm text-gray-600">
                        {{ optional($document->submittedBy)->full_name }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ optional($document->submission_date)?->format('M d, Y h:i A') }}
                    </p>
                </div>
            </div>

            {{-- Assigned --}}
            @if($document->assigned_at)
            <div class="flex gap-4">
                <div class="flex flex-col items-center">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-xs text-white">✓</span>
                    <span class="w-0.5 flex-1 bg-blue-200"></span>
                </div>
                <div class="pb-8">
                    <h3 class="font-semibold">Assigned</h3>
                    <p class="text-sm text-gray-600">
                        {{ optional($document->assignedUser)->full_name }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $document->assigned_at->format('M d, Y h:i A') }}
                    </p>
                </div>
            </div>
            @endif

            {{-- Processing Started --}}
            @if($document->started_processing_at)
            <div class="flex gap-4">
                <div class="flex flex-col items-center">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-yellow-500 text-xs text-white">✓</span>
                    <span class="w-0.5 flex-1 bg-blue-200"></span>
                </div>
                <div class="pb-8">
                    <h3 class="font-semibold">Processing Started</h3>
                    <p class="text-sm text-gray-600">
                        {{ optional($document->assignedUser)->full_name }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $document->started_processing_at->format('M d, Y h:i A') }}
                    </p>
                </div>
            </div>
            @endif

            {{-- Submitted for Approval --}}
            @if($document->submitted_for_approval_at)
            <div class="flex gap-4">
                <div class="flex flex-col items-center">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-500 text-xs text-white">✓</span>
                    <span class="w-0.5 flex-1 bg-blue-200"></span>
                </div>
                <div class="pb-8">
                    <h3 class="font-semibold">Submitted for Approval</h3>
                    <p class="text-sm text-gray-600">
                        {{ optional($document->assignedUser)->full_name }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $document->submitted_for_approval_at->format('M d, Y h:i A') }}
                    </p>
                </div>
            </div>
            @endif

       {{-- Final Outcome: Completed or Rejected --}}
@php
    $finalLog = $document->logs->firstWhere('action', ucfirst($document->status) == 'Completed' ? 'Completed' : 'Rejected');
@endphp

@if($document->status == 'completed')
<div class="flex gap-4">
    <div class="flex flex-col items-center">
        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs text-white">✓</span>
    </div>
    <div>
        <h3 class="font-semibold">Completed</h3>
        <p class="text-sm text-gray-600">
            {{ optional(optional($finalLog)->user)->full_name ?? optional($document->assignedUser)->full_name }}
        </p>
        <p class="text-xs text-gray-400">
            {{ $document->updated_at->format('M d, Y h:i A') }}
        </p>
    </div>
</div>
@elseif($document->status == 'rejected')
<div class="flex gap-4">
    <div class="flex flex-col items-center">
        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-600 text-xs text-white">✕</span>
    </div>
    <div>
        <h3 class="font-semibold">Rejected</h3>
        <p class="text-sm text-gray-600">
            {{ optional(optional($finalLog)->user)->full_name ?? optional($document->assignedUser)->full_name }}
        </p>
        <p class="text-xs text-gray-400">
            {{ $document->updated_at->format('M d, Y h:i A') }}
        </p>
    </div>
</div>
@endif

        </div>

    </div>

</div>

        </div>

    </div>

</x-layouts.employee-layout>