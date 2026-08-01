<x-layouts.admin-layout>

<div class="space-y-8">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold text-gray-900">

            Audit Trail

        </h1>

        <p class="mt-2 text-gray-500">

            Monitor every important activity performed throughout the system.

        </p>

    </div>

</div>

{{-- ========================================================= --}}
{{-- FILTERS --}}
{{-- ========================================================= --}}

<div class="bg-white rounded-2xl border shadow-sm">

    <div class="border-b px-6 py-5">

  <h2 class="text-xl font-bold">
            Filter Audit Logs
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Search and filter system activities.
        </p>
    </div>

    <form method="GET" action="{{ route('admin.audit') }}">

        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-4">

                {{-- Search --}}
                <div class="xl:col-span-2">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Search
                    </label>

                <input
    type="text"
    name="search"
    value="{{ request('search') }}"
    placeholder="Search user, action or description..."
    class="w-full rounded-xl border-gray-300">
                </div>

                {{-- Action --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Action
                    </label>

             <select
    name="action"
    class="w-full rounded-xl border-gray-300">

    <option value="">All Actions</option>

    @foreach([
        'Submitted',
        'Approved',
        'Approved & Routed',
        'Forwarded',
        'Returned',
        'Rejected',
        'Started Processing',
        'Completed'
    ] as $action)

        <option
            value="{{ $action }}"
            @selected(request('action') == $action)>

            {{ $action }}

        </option>

    @endforeach

</select>
                </div>

                {{-- Module --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Module
                    </label>

         <select
    name="module"
    class="w-full rounded-xl border-gray-300">

    <option value="">All Modules</option>

    <option value="Documents"
        @selected(request('module')=='Documents')>

        Documents

    </option>

    <option value="Incoming Documents"
        @selected(request('module')=='Incoming Documents')>

        Incoming Documents

    </option>

</select>

                </div>

                {{-- Date --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Date
                    </label>

                 <input
    type="date"
    name="date"
    value="{{ request('date') }}"
    class="w-full rounded-xl border-gray-300">

                </div>

                {{-- Buttons --}}
              <div class="flex items-end gap-2">

    <button
        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 font-semibold">

        Apply

    </button>

    <a
        href="{{ route('admin.audit') }}"
        class="px-4 py-3 rounded-xl border hover:bg-gray-100">

        Reset

    </a>

</div>

            </div>

        </div>

    </form>

</div>

{{-- ========================================================= --}}
{{-- AUDIT LOGS --}}
{{-- ========================================================= --}}

<div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

    {{-- Card Header --}}
    <div class="px-6 py-5 border-b flex items-center justify-between">

        <div>

            <h2 class="text-xl font-bold">
                Audit Logs
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Complete history of user activities across the system.
            </p>

        </div>

        <span class="text-sm text-gray-500">
           {{ number_format($documents->total()) }}
        </span>

    </div>

    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-gray-200">
{{-- ========================= --}}
{{-- TABLE HEADER --}}
{{-- ========================= --}}

<thead class="bg-gray-50">

<tr>

    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
        Date
    </th>

    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
        Submitted By
    </th>

    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
        Admin Review
    </th>

    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
        User B
    </th>

    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
        User C
    </th>

    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
        Document
    </th>

</tr>

</thead>

            {{-- ========================= --}}
            {{-- TABLE BODY --}}
            {{-- ========================= --}}
<tbody class="divide-y divide-gray-100 bg-white">

@forelse($documents as $document)

@php

    $adminReview = $document->logs->first(function ($log) {
        return in_array(strtolower($log->action), [
            'approved',
            'approved & routed',
            'returned',
            'rejected'
        ]);
    });

    $processingLogs = $document->logs
        ->filter(function ($log) {
            return in_array(strtolower($log->action), [
                'started processing',
                'forwarded',
                'completed'
            ]);
        })
        ->values();

    $userB = $processingLogs->get(0);

    $userC = $processingLogs->get(1);

@endphp

<tr class="hover:bg-gray-50 transition">

    {{-- DATE --}}
    <td class="px-6 py-5 whitespace-nowrap">

        <div class="font-semibold">

            {{ $document->submission_date->format('M d, Y') }}

        </div>

        <div class="text-sm text-gray-500">

            {{ $document->submission_date->format('h:i A') }}

        </div>

    </td>

    {{-- SUBMITTED BY --}}
    <td class="px-6 py-5">

        <div class="font-semibold">

            {{ $document->submittedBy->full_name }}

        </div>

        <div class="text-sm text-gray-500">

            {{ optional($document->submittedBy->office)->office_name }}

        </div>

    </td>

    {{-- ADMIN REVIEW --}}
<td class="px-6 py-5">

@if($adminReview)

    <div class="font-semibold">

        {{ optional($adminReview->user)->full_name }}

    </div>

    <div class="text-sm text-blue-600">

        {{ $adminReview->action }}

    </div>

@else

    <span class="text-gray-400">

        —

    </span>

@endif

</td>

 {{-- USER B --}}
  <td class="px-6 py-5">

@if($userC)

    <div class="font-semibold">

        {{ optional($userC->user)->full_name }}

    </div>

    <div class="text-sm text-gray-500">

        {{ $userC->action }}

    </div>

@else

    <span class="text-gray-400">

        —

    </span>

@endif

</td>

    {{-- USER C --}}
   <td class="px-6 py-5">

@if($userB)

    <div class="font-semibold">

        {{ optional($userB->user)->full_name }}

    </div>

    <div class="text-sm text-gray-500">

        {{ $userB->action }}

    </div>

@else

    <span class="text-gray-400">

        —

    </span>

@endif

</td>

   

    {{-- DOCUMENT --}}
    <td class="px-6 py-5 text-center">

  <button
    onclick="openTimeline({{ $document->id }})"
    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">

    View Timeline

</button>

    </td>

</tr>

@empty

<tr>

    <td colspan="6" class="px-6 py-12 text-center text-gray-500">

        No documents found.

    </td>

</tr>

@endforelse

</tbody>

        </table>

    </div>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t bg-gray-50">

       {{ $documents->links() }}

    </div>

</div>

<div
    id="timelineModal"
    class="fixed inset-0 bg-black/50 hidden z-50 items-center justify-center">

    <div
        class="bg-white rounded-2xl shadow-xl w-full max-w-5xl max-h-[90vh] overflow-hidden">

        <div class="flex justify-between items-center px-6 py-5 border-b">

            <h2 class="text-xl font-bold">

                Document Timeline

            </h2>

            <button
                onclick="closeTimeline()"
                class="text-2xl text-gray-500 hover:text-black">

                ×

            </button>

        </div>

        <div
            id="timelineContent"
            class="p-6 overflow-y-auto max-h-[75vh]">

            Loading...

        </div>

    </div>

</div>

<script>

function openTimeline(id){

    fetch('/admin/audit/'+id)

    .then(response=>response.text())

    .then(html=>{

        document.getElementById('timelineContent').innerHTML=html;

        document.getElementById('timelineModal')
            .classList.remove('hidden');

        document.getElementById('timelineModal')
            .classList.add('flex');

    });

}

function closeTimeline(){

    document.getElementById('timelineModal')
        .classList.remove('flex');

    document.getElementById('timelineModal')
        .classList.add('hidden');

}

</script>


</x-layouts.admin-layout>