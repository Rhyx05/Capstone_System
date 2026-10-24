<x-layouts.employee-layout>

<div class="max-w-6xl mx-auto">

@if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
        <span class="text-lg">✅</span>
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
@endif

@php
    $statusColor = match($document->status){
        'assigned'   => 'bg-blue-50 text-blue-700 border-blue-200',
        'processing' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'completed'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'rejected'   => 'bg-red-50 text-red-700 border-red-200',
        default      => 'bg-gray-100 text-gray-700 border-gray-200',
    };
    $priorityColors = [
        'Low'    => 'bg-green-500',
        'Normal' => 'bg-blue-500',
        'High'   => 'bg-orange-500',
        'Urgent' => 'bg-red-500',
    ];

    // Can the current user still act on this document?
    $canProcess = $document->assigned_to == auth()->id() || $document->sent_to == auth()->id();
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Process Document</h1>
                        <p class="mt-0.5 text-sm text-gray-500">
                            Tracking Code
                            <span class="font-semibold text-indigo-700">{{ $document->tracking_code }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">

                    <span class="px-4 py-2 rounded-full text-xs font-semibold border {{ $statusColor }}">
                        {{ ucwords(str_replace('_', ' ', $document->status)) }}
                    </span>

                    <a
                        href="{{ route('user.incoming') }}"
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
                    <p class="text-sm font-semibold text-gray-800">{{ $document->submission_date->format('M d, Y h:i A') }}</p>
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

            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- ===================================================== --}}
        {{-- OCR + PROCESSING ACTIONS/NOTICE + TIMELINE --}}
        {{-- ===================================================== --}}
        <div class="grid grid-cols-1 xl:grid-cols-3">

            {{-- OCR TEXT --}}

                <div class="xl:col-span-2 px-8 py-6 xl:border-r border-gray-100">

                    <div class="flex items-center gap-2 mb-5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">🔍</span>
                        <h2 class="text-base font-semibold text-gray-900">OCR Extracted Text</h2>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-6 max-h-[600px] overflow-y-auto whitespace-pre-wrap text-sm text-gray-700 leading-7">
                        {{ $document->extracted_text ?: 'No OCR text available.' }}
                    </div>

                </div>


            {{-- RIGHT COLUMN: PROCESSING ACTIONS (or notice) + TIMELINE STACKED (same width) --}}
<div class="flex flex-col">

                @if($canProcess)

                    {{-- Processing Actions --}}
                    <div class="px-8 py-6">

                        <div class="flex items-center gap-2 mb-1">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-purple-50 text-purple-600 text-sm">⚙️</span>
                            <h2 class="text-base font-semibold text-gray-900">Processing Actions</h2>
                        </div>
                        <p class="text-sm text-gray-500 mb-5 ml-9">Select how you want to process this document.</p>

                        <div class="space-y-4">

                            {{-- Approve & Complete --}}
                            <button
                                type="button"
                                onclick="openCompleteModal()"
                                class="w-full text-left rounded-xl bg-green-600 hover:bg-green-700 text-white px-5 py-4 transition">
                                <div class="text-base font-semibold">✅ Approve & Complete</div>
                                <div class="text-xs text-green-100 mt-1">Finish processing this document.</div>
                            </button>

                            {{-- Approve & Forward --}}
                            <button
                                type="button"
                                onclick="openForwardModal()"
                                class="w-full text-left rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-4 transition">
                                <div class="text-base font-semibold">📤 Approve & Forward</div>
                                <div class="text-xs text-blue-100 mt-1">Forward to another employee.</div>
                            </button>

                            {{-- Reject --}}
                            <button
                                type="button"
                                onclick="openRejectModal()"
                                class="w-full text-left rounded-xl bg-red-600 hover:bg-red-700 text-white px-5 py-4 transition">
                                <div class="text-base font-semibold">❌ Reject Document</div>
                                <div class="text-xs text-red-100 mt-1">Reject this document.</div>
                            </button>

                        </div>

                    </div>

                @else

                    {{-- Notice: document no longer actionable by this user --}}
                    <div class="px-8 py-6">

                        <div class="flex items-center gap-2 mb-1">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-100 text-gray-500 text-sm">🔒</span>
                            <h2 class="text-base font-semibold text-gray-900">Processing Actions</h2>
                        </div>

                        <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50 px-4 py-4">
                            <p class="text-sm text-gray-600 leading-6">
                                This document has since been reassigned or is no longer active for you.
                                You can still view its details and history below, but you can no longer take action on it.
                            </p>
                        </div>

                    </div>

                @endif

                <div class="border-t border-gray-100"></div>

                {{-- Document Timeline — same width, stacked below Processing Actions --}}
                <div class="px-8 py-6">

                    <div class="flex items-center gap-2 mb-5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-sm">🕓</span>
                        <h2 class="text-base font-semibold text-gray-900">Document Timeline</h2>
                    </div>

                    <div class="space-y-0">

                        {{-- Submitted --}}
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-600 text-xs text-white">✓</span>
                                <span class="w-0.5 flex-1 bg-blue-100"></span>
                            </div>
                            <div class="pb-8">
                                <h3 class="text-sm font-semibold text-gray-900">Submitted</h3>
                                <p class="text-sm text-gray-600">
                                    {{ optional($document->submittedBy)->full_name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ optional($document->submission_date)?->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>

                        {{-- Assigned --}}
                        @if($document->assigned_at)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-xs text-white">✓</span>
                                <span class="w-0.5 flex-1 bg-blue-100"></span>
                            </div>
                            <div class="pb-8">
                                <h3 class="text-sm font-semibold text-gray-900">Assigned</h3>
                                <p class="text-sm text-gray-600">
                                    {{ optional($document->assignedUser)->full_name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
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
                                <span class="w-0.5 flex-1 bg-blue-100"></span>
                            </div>
                            <div class="pb-8">
                                <h3 class="text-sm font-semibold text-gray-900">Processing Started</h3>
                                <p class="text-sm text-gray-600">
                                    {{ optional($document->assignedUser)->full_name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
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
                                <span class="w-0.5 flex-1 bg-blue-100"></span>
                            </div>
                            <div class="pb-8">
                                <h3 class="text-sm font-semibold text-gray-900">Submitted for Approval</h3>
                                <p class="text-sm text-gray-600">
                                    {{ optional($document->assignedUser)->full_name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
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
                                <h3 class="text-sm font-semibold text-gray-900">Completed</h3>
                                <p class="text-sm text-gray-600">
                                    {{ optional(optional($finalLog)->user)->full_name ?? optional($document->assignedUser)->full_name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
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
                                <h3 class="text-sm font-semibold text-gray-900">Rejected</h3>
                                <p class="text-sm text-gray-600">
                                    {{ optional(optional($finalLog)->user)->full_name ?? optional($document->assignedUser)->full_name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
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

</div>

{{-- ===================================================== --}}
{{-- APPROVE & COMPLETE MODAL --}}
{{-- ===================================================== --}}
@if($canProcess)
<div id="completeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-lg font-bold text-green-700">✅ Approve & Complete</h2>
            <p class="mt-1 text-sm text-gray-500">Complete the processing of this document.</p>
        </div>

        <div class="border-t border-gray-100"></div>

        <form method="POST" action="{{ route('user.incoming.complete', $document) }}">
            @csrf

            <div class="px-8 py-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks</label>
                <textarea
                    name="remarks"
                    rows="5"
                    class="w-full rounded-xl border-gray-300 text-sm focus:border-green-500 focus:ring-green-500"
                    placeholder="Enter completion remarks..."></textarea>
            </div>

            <div class="border-t border-gray-100"></div>

            <div class="flex justify-end gap-3 px-8 py-5">
                <button
                    type="button"
                    onclick="closeCompleteModal()"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    onclick="closeCompleteModal()"
                    class="rounded-xl bg-green-600 hover:bg-green-700 px-6 py-2.5 text-sm font-semibold text-white transition">
                    Complete
                </button>
            </div>

        </form>

    </div>

</div>

{{-- ===================================================== --}}
{{-- APPROVE & FORWARD MODAL --}}
{{-- ===================================================== --}}
<div id="forwardModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-lg font-bold text-blue-700">📤 Approve & Forward</h2>
            <p class="mt-1 text-sm text-gray-500">Approve this document and forward it to another employee.</p>
        </div>

        <div class="border-t border-gray-100"></div>

        <form method="POST" action="{{ route('user.incoming.forward', $document) }}">
            @csrf

            <div class="px-8 py-6 space-y-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Destination Office</label>
                    <select
                        id="officeSelect"
                        name="receiver_office_id"
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                        <option value="">Select Office</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Assign Employee</label>
                    <select
                        id="employeeSelect"
                        name="assigned_to"
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                        <option value="">Select Employee</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" data-office="{{ $user->office_id }}">
                                {{ $user->full_name }} ({{ $user->office->office_name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks</label>
                    <textarea
                        name="remarks"
                        rows="5"
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter forwarding remarks..."></textarea>
                </div>

            </div>

            <div class="border-t border-gray-100"></div>

            <div class="flex justify-end gap-3 px-8 py-5">
                <button
                    type="button"
                    onclick="closeForwardModal()"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    onclick="closeForwardModal()"
                    class="rounded-xl bg-blue-600 hover:bg-blue-700 px-6 py-2.5 text-sm font-semibold text-white transition">
                    Forward
                </button>
            </div>

        </form>

    </div>

</div>

{{-- ===================================================== --}}
{{-- REJECT DOCUMENT MODAL --}}
{{-- ===================================================== --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-lg font-bold text-red-600">❌ Reject Document</h2>
            <p class="mt-1 text-sm text-gray-500">Reject this document and stop the processing.</p>
        </div>

        <div class="border-t border-gray-100"></div>

        <form method="POST" action="{{ route('user.incoming.reject', $document) }}">
            @csrf

            <div class="px-8 py-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks</label>
                <textarea
                    name="remarks"
                    rows="5"
                    required
                    class="w-full rounded-xl border-gray-300 text-sm focus:border-red-500 focus:ring-red-500"
                    placeholder="Enter rejection remarks..."></textarea>
            </div>

            <div class="border-t border-gray-100"></div>

            <div class="flex justify-end gap-3 px-8 py-5">
                <button
                    type="button"
                    onclick="closeRejectModal()"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    onclick="closeRejectModal()"
                    class="rounded-xl bg-red-600 hover:bg-red-700 px-6 py-2.5 text-sm font-semibold text-white transition">
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
@endif

</x-layouts.employee-layout>