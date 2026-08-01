<x-layouts.employee-layout>



@if(session('success'))
<div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-6 py-4 text-green-700">
    {{ session('success') }}
</div>
@endif

<div class="space-y-6">
{{-- ========================================================= --}}
{{-- PAGE HEADER --}}
{{-- ========================================================= --}}

@php

$statusColor = match($document->status){

    'assigned' => 'bg-blue-100 text-blue-700',

    'processing' => 'bg-yellow-100 text-yellow-700',

    'completed' => 'bg-green-100 text-green-700',

    'rejected' => 'bg-red-100 text-red-700',

    default => 'bg-gray-100 text-gray-700',

};

@endphp

<div class="grid grid-cols-3 items-center mb-8">

    {{-- Left --}}
    <div>

        <h1 class="text-2xl font-bold text-gray-900">

            Process Document

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

        <span class="px-5 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">

            {{ ucwords(str_replace('_',' ',$document->status)) }}

        </span>

    </div>

    {{-- Right --}}
    <div class="flex justify-end">

        <a
            href="{{ route('user.incoming') }}"
            class="w-16 h-16 rounded-xl border border-gray-200 bg-white hover:bg-gray-100 hover:border-blue-300 hover:text-blue-600 flex flex-col items-center justify-center transition">

            <span class="text-2xl">

                ←

            </span>

            <span class="text-xs mt-1">

                Back

            </span>

        </a>

    </div>

</div>
{{-- ===================================================== --}}
{{-- DOCUMENT DETAILS --}}
{{-- ===================================================== --}}

<div class="bg-white rounded-2xl border shadow-sm mb-6">

    <div class="px-6 py-5 border-b">

        <h2 class="text-xl font-bold">

            Document Details

        </h2>

    </div>

    <div class="p-5">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Submitted By --}}
            <div>

                <p class="text-xs uppercase text-gray-500 tracking-wide">

                    Submitted By

                </p>

                <p class="font-semibold mt-2">

                    {{ optional($document->submittedBy)->full_name }}

                </p>

            </div>

            {{-- Title --}}
            <div class="text-center">

                <p class="text-xs uppercase text-gray-500 tracking-wide">

                    Title

                </p>

                <p class="font-semibold mt-2">

                    {{ $document->title }}

                </p>

            </div>

            {{-- Submitted On --}}
            <div>

                <p class="text-xs uppercase text-gray-500 tracking-wide">

                    Submitted On

                </p>

                <p class="font-semibold mt-2">

                    {{ $document->submission_date->format('M d, Y h:i A') }}

                </p>

            </div>

            {{-- Office --}}
            <div>

                <p class="text-xs uppercase text-gray-500 tracking-wide">

                    Office

                </p>

                <p class="font-semibold mt-2">

                    {{ optional($document->office)->office_name }}

                </p>

            </div>

            {{-- Category --}}
            <div class="text-center">

                <p class="text-xs uppercase text-gray-500 tracking-wide">

                    Category

                </p>

                <p class="font-semibold mt-2">

                    {{ $document->category }}

                </p>

            </div>

            {{-- Priority --}}
            <div>

                <p class="text-xs uppercase text-gray-500 tracking-wide">

                    Priority

                </p>

                <span class="inline-flex mt-2 px-3 py-1 rounded-full

                    @switch($document->priority)

                        @case('Urgent')
                            bg-red-100 text-red-700
                            @break

                        @case('High')
                            bg-orange-100 text-orange-700
                            @break

                        @case('Normal')
                            bg-blue-100 text-blue-700
                            @break

                        @default
                            bg-gray-100 text-gray-700

                    @endswitch">

                    {{ $document->priority }}

                </span>

            </div>

        </div>

    </div>

</div>

{{-- ===================================================== --}}
{{-- OCR + PROCESSING ACTIONS --}}
{{-- ===================================================== --}}

<div class="grid grid-cols-12 gap-6">

    {{-- OCR TEXT --}}
    <div class="col-span-12 xl:col-span-8">

    @if(!Str::contains(strtolower($document->file_type), 'pdf'))

    <div class="bg-white rounded-2xl border shadow-sm">

        {{-- Header --}}
        <div class="border-b px-6 py-5 flex items-center justify-between">

            <h2 class="text-xl font-bold">

                OCR Extracted Text

            </h2>

        </div>

        {{-- OCR Text --}}
        <div class="p-6">

            <div class="rounded-xl border bg-gray-50 p-6 max-h-[700px] overflow-y-auto whitespace-pre-wrap text-sm leading-7">

                {{ $document->extracted_text ?: 'No OCR text available.' }}

            </div>

        </div>

    </div>

    @endif

</div>
{{-- ===================================================== --}}
{{-- PROCESSING ACTIONS --}}
{{-- ===================================================== --}}
<div class="col-span-12 xl:col-span-4">

    <div class="sticky top-6 bg-white rounded-2xl border shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="border-b px-6 py-5">

            <h2 class="text-xl font-bold">

                Processing Actions

            </h2>

            <p class="text-sm text-gray-500 mt-1">

                Select how you want to process this document.

            </p>

        </div>

        {{-- Buttons --}}
        <div class="p-6 space-y-4">

            {{-- Approve & Complete --}}
            <button
                type="button"
                onclick="openCompleteModal()"
                class="w-full rounded-xl bg-green-600 hover:bg-green-700 text-white px-5 py-4 transition">

                <div class="text-lg font-semibold">

                    ✅ Approve & Complete

                </div>

                <div class="text-sm text-green-100 mt-1">

                    Finish processing this document.

                </div>

            </button>

            {{-- Approve & Forward --}}
            <button
                type="button"
                onclick="openForwardModal()"
                class="w-full rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-4 transition">

                <div class="text-lg font-semibold">

                    📤 Approve & Forward

                </div>

                <div class="text-sm text-blue-100 mt-1">

                    Forward to another employee.

                </div>

            </button>

            {{-- Reject --}}
            <button
                type="button"
                onclick="openRejectModal()"
                class="w-full rounded-xl bg-red-600 hover:bg-red-700 text-white px-5 py-4 transition">

                <div class="text-lg font-semibold">

                    ❌ Reject Document

                </div>

                <div class="text-sm text-red-100 mt-1">

                    Reject this document.

                </div>

            </button>

        </div>

    </div>

</div>

{{-- ===================================================== --}}
{{-- APPROVE & COMPLETE MODAL --}}
{{-- ===================================================== --}}

<div
    id="completeModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="border-b px-6 py-5">

            <h2 class="text-2xl font-bold text-green-700">

                ✅ Approve & Complete

            </h2>

            <p class="mt-1 text-sm text-gray-500">

                Complete the processing of this document.

            </p>

        </div>

<form
    method="POST"
    action="{{ route('user.incoming.complete', $document) }}">
    @csrf

            {{-- Body --}}
            <div class="p-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">

                    Remarks

                </label>

                <textarea
                    name="remarks"
                    rows="5"
                    class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                    placeholder="Enter completion remarks..."></textarea>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 border-t px-6 py-5">

                <button
                    type="button"
                    onclick="closeCompleteModal()"
                    class="rounded-xl border border-gray-300 px-5 py-2 hover:bg-gray-100 transition">

                    Cancel

                </button>

                <button
                    type="submit"
                 onclick="closeCompleteModal()"
                    class="rounded-xl bg-blue-600 px-6 py-2 font-semibold text-white hover:bg-blue-700">

                   Complete

                </button>

            </div>

        </form>

    </div>

</div>

</div>

{{-- ===================================================== --}}
{{-- APPROVE & FORWARD MODAL --}}
{{-- ===================================================== --}}

<div
    id="forwardModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="border-b px-6 py-5">

            <h2 class="text-2xl font-bold text-blue-700">

                📤 Approve & Forward

            </h2>

            <p class="mt-1 text-sm text-gray-500">

                Approve this document and forward it to another employee.

            </p>

        </div>

<form
    method="POST"
    action="{{ route('user.incoming.forward', $document) }}">
    @csrf

            <div class="p-6 space-y-6">

                {{-- Destination Office --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Destination Office

                    </label>

                    <select
                        id="officeSelect"
                        name="receiver_office_id"
                        class="w-full rounded-xl border-gray-300"
                        required>

                        <option value="">

                            Select Office

                        </option>

                        @foreach($offices as $office)

                            <option value="{{ $office->id }}">

                                {{ $office->office_name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Employee --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Assign Employee

                    </label>

                    <select
                        id="employeeSelect"
                        name="assigned_to"
                        class="w-full rounded-xl border-gray-300"
                        required>

                        <option value="">

                            Select Employee

                        </option>

                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                data-office="{{ $user->office_id }}">

                                {{ $user->full_name }}
                                ({{ $user->office->office_name }})

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Remarks --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Remarks

                    </label>

                    <textarea
                        name="remarks"
                        rows="5"
                        class="w-full rounded-xl border-gray-300"
                        placeholder="Enter forwarding remarks..."></textarea>

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 border-t px-6 py-5">

                <button
                    type="button"
                    onclick="closeForwardModal()"
                    class="rounded-xl border border-gray-300 px-5 py-2 hover:bg-gray-100">

                    Cancel

                </button>

                <button
                    type="submit"
                 onclick="closeForwardModal()"
                    class="rounded-xl bg-blue-600 px-6 py-2 font-semibold text-white hover:bg-blue-700">

                   Forward

                </button>

            </div>

        </form>

    </div>

</div>

{{-- ===================================================== --}}
{{-- REJECT DOCUMENT MODAL --}}
{{-- ===================================================== --}}

<div
    id="rejectModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="border-b px-6 py-5">

            <h2 class="text-2xl font-bold text-red-600">

                ❌ Reject Document

            </h2>

            <p class="mt-1 text-sm text-gray-500">

                Reject this document and stop the processing.

            </p>

        </div>

<form
    method="POST"
    action="{{ route('user.incoming.reject', $document) }}">
    @csrf

            <div class="p-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">

                    Remarks

                </label>

                <textarea
                    name="remarks"
                    rows="5"
                    required
                    class="w-full rounded-xl border-gray-300"
                    placeholder="Enter rejection remarks..."></textarea>

            </div>

            <div class="flex justify-end gap-3 border-t px-6 py-5">

                <button
                    type="button"
                    onclick="closeRejectModal()"
                    class="rounded-xl border border-gray-300 px-5 py-2 hover:bg-gray-100">

                    Cancel

                </button>

                 <button
                    type="submit"
                  onclick="closeRejectModal()"
                    class="rounded-xl bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700">

                    Reject Document

                </button>

            </div>

        </form>

    </div>

</div>

<script>
function showModal(id){
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function hideModal(id){
    const modal = document.getElementById(id);
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

function openCompleteModal(){ showModal('completeModal'); }
function closeCompleteModal(){ hideModal('completeModal'); }

function openForwardModal(){ showModal('forwardModal'); }
function closeForwardModal(){ hideModal('forwardModal'); }

function openRejectModal(){ showModal('rejectModal'); }
function closeRejectModal(){ hideModal('rejectModal'); }

document.addEventListener('DOMContentLoaded', function(){

    const office = document.getElementById('officeSelect');
    const employee = document.getElementById('employeeSelect');

    if (office && employee) {

        office.addEventListener('change', function(){

            const officeId = this.value;

            [...employee.options].forEach(option => {

                if (!option.dataset.office) return;

                option.hidden = option.dataset.office !== officeId;

            });

            employee.value = '';

        });

    }

});

</script>
        

</x-layouts.employee-layout>

