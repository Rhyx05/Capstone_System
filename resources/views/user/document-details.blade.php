<x-layouts.employee-layout>

<div class="max-w-6xl mx-auto">

    {{-- ================= Single Unified Card ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

{{-- ===================================================== --}}
{{-- HEADER --}}
{{-- ===================================================== --}}
<div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">

    <div class="grid grid-cols-3 items-center">

        {{-- Left --}}
        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm border border-indigo-100">

                <svg class="w-6 h-6 text-indigo-500"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                </svg>

            </div>

            <div>

                <h1 class="text-xl font-bold text-gray-900">
                    Document Details
                </h1>

                <p class="mt-0.5 text-sm text-gray-500">
                    Tracking Code
                    <span class="font-semibold text-indigo-700">
                        {{ $document->tracking_code }}
                    </span>
                </p>

            </div>

        </div>

        {{-- Center --}}
        <div class="flex justify-center">

            @php
                $statusColors = [
                    'for_review' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                    'approved'   => 'bg-green-50 text-green-700 border-green-200',
                    'assigned'   => 'bg-blue-50 text-blue-700 border-blue-200',
                    'returned'   => 'bg-orange-50 text-orange-700 border-orange-200',
                    'rejected'   => 'bg-red-50 text-red-700 border-red-200',
                    'completed'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                ];
            @endphp

            <span class="px-5 py-2 rounded-full text-xs font-semibold border {{ $statusColors[$document->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">

                {{ ucwords(str_replace('_', ' ', $document->status)) }}

            </span>

        </div>

        {{-- Right --}}
        <div class="flex justify-end">

            <a href="{{ route('user.documents') }}"
               class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-600 transition hover:border-indigo-200 hover:bg-gray-50 hover:text-indigo-600">

                <span>←</span>
                Back

            </a>

        </div>

    </div>

</div>

<div class="border-t border-gray-100"></div>

        {{-- ===================================================== --}}
        {{-- DOCUMENT INFORMATION --}}
        {{-- ===================================================== --}}
        <div class="px-8 py-6">

            <div class="flex items-center gap-2 mb-5">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-sm">📄</span>
                <h2 class="text-base font-semibold text-gray-900">Document Information</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Title</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $document->title }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Category</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $document->category }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Priority</p>
                    @php
                        $priorityColors = [
                            'Low'    => 'bg-green-500',
                            'Normal' => 'bg-blue-500',
                            'High'   => 'bg-orange-500',
                            'Urgent' => 'bg-red-500',
                        ];
                    @endphp
                    <p class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full {{ $priorityColors[$document->priority] ?? 'bg-gray-400' }}"></span>
                        {{ $document->priority }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Submitted</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $document->submission_date->format('F d, Y h:i A') }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Office</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $document->office->office_name ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Description</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $document->description ?: 'No description provided.' }}</p>
                </div>

            </div>
        </div>

        <div class="border-t border-gray-300"></div>

        {{-- ===================================================== --}}
        {{-- PREVIEW + REMARKS + TIMELINE --}}
        {{-- ===================================================== --}}
        <div class="grid grid-cols-1 xl:grid-cols-3">

            {{-- OCR PREVIEW --}}
            <div class="xl:col-span-2 px-8 py-6 xl:border-r border-gray-300">

                <div class="flex items-center gap-2 mb-5">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">🔍</span>
                    <h2 class="text-base font-semibold text-gray-900">OCR Extracted Text</h2>
                </div>

                @if($document->file_type == 'pdf')

                    <iframe
                        src="{{ asset('storage/'.$document->file_path) }}"
                        class="w-full h-[600px] rounded-xl border border-gray-200">
                    </iframe>

                @else

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-6 max-h-[600px] overflow-y-auto whitespace-pre-wrap text-sm text-gray-700 leading-7">
                        {{ $document->extracted_text ?: 'No extracted text available.' }}
                    </div>

                @endif

            </div>

            {{-- REMARKS + TIMELINE --}}
            <div class="px-8 py-6 space-y-8">

                {{-- Remarks --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-purple-50 text-purple-600 text-sm">💬</span>
                        <h2 class="text-base font-semibold text-gray-900">Remarks</h2>
                    </div>
                    <p class="text-sm text-gray-700 leading-6">{{ $document->remarks ?: 'No remarks yet.' }}</p>
                </div>

                <div class="border-t border-gray-300"></div>

                {{-- Timeline --}}
                <div>
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

</x-layouts.employee-layout>