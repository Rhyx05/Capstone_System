<x-layouts.admin-layout>

<div class="max-w-6xl mx-auto">

@php
    $statusColor = match($document->status){
        'for_review' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'approved'   => 'bg-green-50 text-green-700 border-green-200',
        'assigned'   => 'bg-blue-50 text-blue-700 border-blue-200',
        'returned'   => 'bg-orange-50 text-orange-700 border-orange-200',
        'rejected'   => 'bg-red-50 text-red-700 border-red-200',
        'completed'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        default      => 'bg-gray-100 text-gray-700 border-gray-200',
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Review Document</h1>
                        <p class="mt-0.5 text-sm text-gray-500">
                            Tracking Code
                            <span class="font-semibold text-indigo-700">{{ $document->tracking_code }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">

                    <a
                        href="{{ route('admin.documents') }}"
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
                    <p class="text-sm font-semibold text-gray-800">{{ $document->submittedBy->full_name }}</p>
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

        <div class="border-t border-gray-400"></div>

        {{-- ===================================================== --}}
        {{-- OCR + REVIEW ACTIONS --}}
        {{-- ===================================================== --}}
        <div class="grid grid-cols-1 xl:grid-cols-3">

            {{-- OCR TEXT --}}
        
                <div class="xl:col-span-2 px-8 py-6 xl:border-r border-gray-400">

                    <div class="flex items-center gap-2 mb-5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">🔍</span>
                        <h2 class="text-base font-semibold text-gray-900">OCR Extracted Text</h2>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-6 max-h-[600px] overflow-y-auto whitespace-pre-wrap text-sm text-gray-700 leading-7">
                        {{ $document->extracted_text ?: 'No OCR text available.' }}
                    </div>

                </div>


            {{-- REVIEW ACTIONS --}}
<div class="px-8 py-6">

                <div class="flex items-center gap-2 mb-1">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-purple-50 text-purple-600 text-sm">⚙️</span>
                    <h2 class="text-base font-semibold text-gray-900">Review Actions</h2>
                </div>
                <p class="text-sm text-gray-500 mb-5 ml-9">Select the appropriate action for this document.</p>

                <div class="space-y-4">

                    {{-- Approve --}}
                    <button
                        type="button"
                        onclick="openApproveModal()"
                        class="w-full text-left rounded-xl bg-green-600 hover:bg-green-700 text-white px-5 py-4 transition">
                        <div class="text-base font-semibold">✅ Approve Document</div>
                        <div class="text-xs text-green-100 mt-1">Finish review without routing.</div>
                    </button>

                    {{-- Approve & Route --}}
                    <button
                        type="button"
                        onclick="openRouteModal()"
                        class="w-full text-left rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-4 transition">
                        <div class="text-base font-semibold">📤 Approve & Route</div>
                        <div class="text-xs text-blue-100 mt-1">Approve then assign to an employee.</div>
                    </button>

                    {{-- Return --}}
                    <button
                        type="button"
                        onclick="openReturnModal()"
                        class="w-full text-left rounded-xl bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-4 transition">
                        <div class="text-base font-semibold">↩ Return Document</div>
                        <div class="text-xs text-yellow-100 mt-1">Send document back to submitter.</div>
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ===================================================== --}}
{{-- APPROVE MODAL --}}
{{-- ===================================================== --}}
<div id="approveModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-lg font-bold text-green-700">✅ Approve Document</h2>
            <p class="mt-1 text-sm text-gray-500">Approve this document without routing it to another employee.</p>
        </div>

        <div class="border-t border-gray-400"></div>

        <form method="POST" action="{{ route('admin.documents.approve', $document) }}">
            @csrf

            <div class="px-8 py-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks</label>
                <textarea
                    name="remarks"
                    rows="5"
                    class="w-full rounded-xl border-gray-300 text-sm focus:border-green-500 focus:ring-green-500"
                    placeholder="Enter approval remarks..."></textarea>
            </div>

            <div class="border-t border-gray-400"></div>

            <div class="flex justify-end gap-3 px-8 py-5">
                <button
                    type="button"
                    onclick="closeApproveModal()"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    onclick="closeApproveModal()"
                    class="rounded-xl bg-green-600 hover:bg-green-700 px-6 py-2.5 text-sm font-semibold text-white transition">
                    Approve
                </button>
            </div>

        </form>

    </div>

</div>

{{-- ===================================================== --}}
{{-- APPROVE & ROUTE MODAL --}}
{{-- ===================================================== --}}
<div id="routeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-lg font-bold text-blue-700">📤 Approve & Route Document</h2>
            <p class="mt-1 text-sm text-gray-500">Approve this document and assign it to a designated employee.</p>
        </div>

        <div class="border-t border-gray-100"></div>

        <form method="POST" action="{{ route('admin.documents.approve-route', $document) }}">
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
                        placeholder="Enter routing remarks..."></textarea>
                </div>

            </div>

            <div class="border-t border-gray-100"></div>

            <div class="flex justify-end gap-3 px-8 py-5">
                <button
                    type="button"
                    onclick="closeRouteModal()"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    onclick="closeRouteModal()"
                    class="rounded-xl bg-blue-600 hover:bg-blue-700 px-6 py-2.5 text-sm font-semibold text-white transition">
                    Route Document
                </button>
            </div>

        </form>

    </div>

</div>

{{-- ===================================================== --}}
{{-- RETURN MODAL --}}
{{-- ===================================================== --}}
<div id="returnModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden">

        <div class="px-8 py-6">
            <h2 class="text-lg font-bold text-yellow-600">↩ Return Document</h2>
            <p class="mt-1 text-sm text-gray-500">Return this document back to the submitter for revision.</p>
        </div>

        <div class="border-t border-gray-100"></div>

        <form method="POST" action="{{ route('admin.documents.return', $document) }}">
            @csrf

            <div class="px-8 py-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks</label>
                <textarea
                    name="remarks"
                    rows="5"
                    required
                    class="w-full rounded-xl border-gray-300 text-sm focus:border-yellow-500 focus:ring-yellow-500"
                    placeholder="State why this document is being returned..."></textarea>
            </div>

            <div class="border-t border-gray-100"></div>

            <div class="flex justify-end gap-3 px-8 py-5">
                <button
                    type="button"
                    onclick="closeReturnModal()"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    onclick="closeReturnModal()"
                    class="rounded-xl bg-yellow-500 hover:bg-yellow-600 px-6 py-2.5 text-sm font-semibold text-white transition">
                    Return Document
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

function openApproveModal(){ showModal('approveModal'); }
function closeApproveModal(){ hideModal('approveModal'); }

function openRouteModal(){ showModal('routeModal'); }
function closeRouteModal(){ hideModal('routeModal'); }

function openReturnModal(){ showModal('returnModal'); }
function closeReturnModal(){ hideModal('returnModal'); }

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

</x-layouts.admin-layout>