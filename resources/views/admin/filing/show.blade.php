<x-layouts.admin-layout>

<div class="space-y-8">

    {{-- ====================================================== --}}
    {{-- PAGE HEADER --}}
    {{-- ====================================================== --}}

    <div class="flex items-start justify-between">

        <div>

            <a
                href="{{ route('admin.filing.index') }}"
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700">

                ← Back to Electronic Filing

            </a>

            <h1 class="mt-5 text-3xl font-bold text-gray-900">

                Archive Document

            </h1>

            <p class="mt-2 text-gray-500">

                Review the document details before assigning it to a repository.

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
     {{-- ===================================================== --}}
{{-- DOCUMENT PREVIEW --}}
{{-- ===================================================== --}}

<div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

    <div class="border-b px-6 py-5">

        <h2 class="text-xl font-bold text-gray-900">

            Document Preview

        </h2>

        <p class="text-sm text-gray-500 mt-1">

            {{ $document->file_name }}

        </p>

    </div>

    @if(Str::contains(strtolower($document->file_type),'pdf'))

        <iframe
            src="{{ asset('storage/'.$document->file_path) }}"
            class="w-full h-[900px]">

        </iframe>

    @else

        <div class="p-6">

            <div class="rounded-xl border bg-gray-50 p-6 max-h-[700px] overflow-y-auto whitespace-pre-wrap text-sm leading-7 text-gray-800">

                {{ $document->extracted_text ?: 'No extracted content available for this file.' }}

            </div>

        </div>

    @endif

</div>
        {{-- ====================================================== --}}
    {{-- ARCHIVE DOCUMENT --}}
    {{-- ====================================================== --}}

   <div class="bg-white rounded-2xl border shadow-sm">

<div class="border-b px-6 py-5">

<h2 class="text-xl font-bold">

Archive

</h2>

</div>

<form
method="POST"
action="{{ route('admin.filing.documents.archive',$document) }}">

@csrf

<div class="p-6 space-y-5">

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

<button
class="w-full rounded-xl bg-blue-600 hover:bg-blue-700 py-3 text-white font-semibold">

📦 Archive Document

</button>

</div>

</form>

</div>
    </div>

</div>

</x-layouts.admin-layout>