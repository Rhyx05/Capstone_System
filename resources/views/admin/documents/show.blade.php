<x-layouts.admin-layout>


{{-- ========================================================= --}}
{{-- PAGE HEADER --}}
{{-- ========================================================= --}}

@php

    $statusColor = match($document->status){

        'for_review' => 'bg-yellow-300 text-yellow-700',

        'approved' => 'bg-green-300 text-green-700',

        'assigned' => 'bg-blue-300 text-blue-700',

        'returned' => 'bg-orange-300 text-orange-700',

        'rejected' => 'bg-red-300 text-red-700',

        'completed' => 'bg-emerald-300 text-emerald-700',

        default => 'bg-gray-300 text-gray-700',

    };

@endphp

<div class="grid grid-cols-3 items-center mb-8">

    {{-- Left: Icon + Title --}}
    <div class="flex items-center gap-4">


        {{-- Title --}}
        <div>

            <h1 class="text-2xl font-bold text-gray-900">

                Review Document

            </h1>

            <p class="mt-1 text-gray-500">

                Tracking Code

                <span class="font-semibold text-blue-700">

                    {{ $document->tracking_code }}

                </span>

            </p>

        </div>

    </div>

    {{-- Center: Status --}}
    <div class="flex justify-center">

        <span class="px-5 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">

            {{ ucwords(str_replace('_',' ',$document->status)) }}

        </span>

    </div>

{{-- Right: Back Button --}}
<div class="flex justify-end">

    <a
        href="{{ route('admin.documents') }}"
        class="w-16 h-16 rounded-xl border border-gray-200 bg-white hover:bg-gray-100 hover:border-blue-300 hover:text-blue-600 flex flex-col items-center justify-center transition">

        <span class="text-2xl leading-none">←</span>

        <span class="text-xs font-medium mt-1">
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

            <div>

                <p class="text-xs uppercase text-gray-500 tracking-wide">

                    Submitted By

                </p>

                <p class="font-semibold mt-2">

                    {{ $document->submittedBy->full_name }}

                </p>

            </div>

<div class="text-center">
    <p class="text-xs uppercase text-gray-500 tracking-wide">
        Title
    </p>

    <p class="font-semibold mt-2">
        {{ $document->title }}
    </p>
</div>


            <div>

                <p class="text-xs uppercase text-gray-500 tracking-wide">

                    Submitted On

                </p>

                <p class="font-semibold mt-2">

                    {{ $document->submission_date->format('M d, Y h:i A') }}

                </p>

            </div>


            <div>

                <p class="text-xs uppercase text-gray-500 tracking-wide">

                    Office

                </p>

                <p class="font-semibold mt-2">

                    {{ optional($document->office)->office_name }}

                </p>

            </div>

<div class="text-center">
    <p class="text-xs uppercase text-gray-500 tracking-wide">
        Category
    </p>

    <p class="font-semibold mt-2">
        {{ $document->category }}
    </p>
</div>

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

<div class="grid grid-cols-12 gap-6">

    {{-- ===================================================== --}}
    {{-- OCR TEXT --}}
    {{-- ===================================================== --}}
    <div class="col-span-12 xl:col-span-8">

        @if(!Str::contains(strtolower($document->file_type), 'pdf'))

        <div class="bg-white rounded-2xl border shadow-sm">

<div class="border-b px-6 py-5 flex items-center justify-between">

    <h2 class="text-xl font-bold">
        OCR Extracted Text
    </h2>


</div>

            <div class="p-6">

                <div class="rounded-xl border bg-gray-50 p-6 max-h-[700px] overflow-y-auto whitespace-pre-wrap text-sm leading-7">

                    {{ $document->extracted_text ?: 'No OCR text available.' }}

                </div>

            </div>

        </div>

        @endif

    </div>

  {{-- ===================================================== --}}
{{-- REVIEW ACTIONS --}}
{{-- ===================================================== --}}
<div class="col-span-12 xl:col-span-4">

    <div class="sticky top-6 bg-white rounded-2xl border shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="border-b px-6 py-5">

            <h2 class="text-xl font-bold">
                Review Actions
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Select the appropriate action for this document.
            </p>

        </div>

        {{-- Buttons --}}
        <div class="p-6 space-y-4">

            {{-- Approve --}}
            <button
                type="button"
                onclick="openApproveModal()"
                class="w-full rounded-xl bg-green-600 hover:bg-green-700 text-white px-5 py-4 transition">

                <div class="text-lg font-semibold">

                    ✅ Approve Document

                </div>

                <div class="text-sm text-green-100 mt-1">

                    Finish review without routing

                </div>

            </button>

            {{-- Approve & Route --}}
            <button
                type="button"
                onclick="openRouteModal()"
                class="w-full rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-4 transition">

                <div class="text-lg font-semibold">

                    📤 Approve & Route

                </div>

                <div class="text-sm text-blue-100 mt-1">

                    Approve then assign to an employee

                </div>

            </button>

            {{-- Return --}}
            <button
                type="button"
                onclick="openReturnModal()"
                class="w-full rounded-xl bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-4 transition">

                <div class="text-lg font-semibold">

                    ↩ Return Document

                </div>

                <div class="text-sm text-yellow-100 mt-1">

                    Send document back to submitter

                </div>

            </button>


        </div>

    </div>


{{-- ===================================================== --}}
{{-- JAVASCRIPT --}}
{{-- ===================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const officeSelect = document.getElementById('officeSelect');
    const employeeSelect = document.getElementById('employeeSelect');

    if (officeSelect && employeeSelect) {

        officeSelect.addEventListener('change', function () {

            const officeId = this.value;

            Array.from(employeeSelect.options).forEach(function(option){

                if(option.value === ''){

                    option.hidden = false;
                    return;

                }

                option.hidden = option.dataset.office !== officeId;

            });

            employeeSelect.value = '';

        });

    }

});

</script>

{{-- ===================================================== --}}
{{-- APPROVE MODAL --}}
{{-- ===================================================== --}}

<div
    id="approveModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="border-b px-6 py-5">

            <h2 class="text-2xl font-bold">

                ✅ Approve Document

            </h2>

            <p class="mt-1 text-sm text-gray-500">

                Approve this document without routing it to another employee.

            </p>

        </div>

        <form
            method="POST"
            action="{{ route('admin.documents.approve', $document) }}">

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
                    placeholder="Enter approval remarks..."></textarea>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 border-t px-6 py-5">

                <button
                    type="button"
                    onclick="closeApproveModal()"
                    class="rounded-xl border border-gray-300 px-5 py-2 hover:bg-gray-100 transition">

                    Cancel

                </button>

<button
    type="submit"
    onclick="closeApproveModal()"
    class="rounded-xl bg-green-600 px-6 py-2 font-semibold text-white hover:bg-green-700">

    Approve

</button>

            </div>

        </form>

    </div>

</div>

<script>

function openApproveModal(){

    document
        .getElementById('approveModal')
        .classList.remove('hidden');

    document
        .getElementById('approveModal')
        .classList.add('flex');

}

function closeApproveModal(){

    document
        .getElementById('approveModal')
        .classList.remove('flex');

    document
        .getElementById('approveModal')
        .classList.add('hidden');

}

</script>

{{-- ===================================================== --}}
{{-- APPROVE & ROUTE MODAL --}}
{{-- ===================================================== --}}

<div
    id="routeModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="border-b px-6 py-5">

            <h2 class="text-2xl font-bold">

                📤 Approve & Route Document

            </h2>

            <p class="mt-1 text-sm text-gray-500">

                Approve this document and assign it to a designated employee.

            </p>

        </div>

        <form
            method="POST"
            action="{{ route('admin.documents.approve-route',$document) }}">

            @csrf

            <div class="p-6 space-y-6">

                {{-- Office --}}
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
                        placeholder="Enter routing remarks..."></textarea>

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 border-t px-6 py-5">

                <button
                    type="button"
                    onclick="closeRouteModal()"
                    class="rounded-xl border border-gray-300 px-5 py-2 hover:bg-gray-100">

                    Cancel

                </button>

                <button
                    type="submit"
                 onclick="closeRouteModal()"
                    class="rounded-xl bg-blue-600 px-6 py-2 font-semibold text-white hover:bg-blue-700">

                    Route Document

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openRouteModal(){

    document
        .getElementById('routeModal')
        .classList.remove('hidden');

    document
        .getElementById('routeModal')
        .classList.add('flex');

}

function closeRouteModal(){

    document
        .getElementById('routeModal')
        .classList.remove('flex');

    document
        .getElementById('routeModal')
        .classList.add('hidden');

}

document.addEventListener('DOMContentLoaded', function () {

    const office = document.getElementById('officeSelect');

    const employee = document.getElementById('employeeSelect');

    office.addEventListener('change', function () {

        const officeId = this.value;

        [...employee.options].forEach(option => {

            if (!option.dataset.office) return;

            option.hidden = option.dataset.office !== officeId;

        });

        employee.value = '';

    });

});

</script>

{{-- ===================================================== --}}
{{-- RETURN MODAL --}}
{{-- ===================================================== --}}

<div
    id="returnModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="border-b px-6 py-5">

            <h2 class="text-2xl font-bold text-yellow-600">

                ↩ Return Document

            </h2>

            <p class="mt-1 text-sm text-gray-500">

                Return this document back to the submitter for revision.

            </p>

        </div>

        <form
            method="POST"
            action="{{ route('admin.documents.return', $document) }}">

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
                    placeholder="State why this document is being returned..."></textarea>

            </div>

            <div class="flex justify-end gap-3 border-t px-6 py-5">

                <button
                    type="button"
                    onclick="closeReturnModal()"
                    class="rounded-xl border border-gray-300 px-5 py-2 hover:bg-gray-100">

                    Cancel

                </button>

                <button
                    type="submit"
                 onclick="closeReturnModal()"
                    class="rounded-xl bg-yellow-500 px-6 py-2 font-semibold text-white hover:bg-yellow-600">

                    Return Document

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function showModal(id){

    const modal=document.getElementById(id);

    modal.classList.remove('hidden');

    modal.classList.add('flex');

}

function hideModal(id){

    const modal=document.getElementById(id);

    modal.classList.remove('flex');

    modal.classList.add('hidden');

}

function openApproveModal(){ showModal('approveModal'); }

function closeApproveModal(){ hideModal('approveModal'); }

function openRouteModal(){ showModal('routeModal'); }

function closeRouteModal(){ hideModal('routeModal'); }

function openReturnModal(){ showModal('returnModal'); }

function closeReturnModal(){ hideModal('returnModal'); }

document.addEventListener('DOMContentLoaded', function(){

    const office=document.getElementById('officeSelect');

    const employee=document.getElementById('employeeSelect');

    if(office && employee){

        office.addEventListener('change',function(){

            const officeId=this.value;

            [...employee.options].forEach(option=>{

                if(!option.dataset.office) return;

                option.hidden=option.dataset.office!==officeId;

            });

            employee.value='';

        });

    }

});

</script>
</x-layouts.admin-layout>