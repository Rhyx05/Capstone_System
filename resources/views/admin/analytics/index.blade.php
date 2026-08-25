<x-layouts.admin-layout>

<div class="max-w-7xl mx-auto space-y-6">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-8 py-7">
            <div class="flex items-center justify-between gap-4">

                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white border border-indigo-100 shadow-sm">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16M7 16V8m5 8V5m5 11v-3"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Analytics</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Executive reporting dashboard for document management.</p>
                    </div>
                </div>


            </div>
        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- EXECUTIVE SUMMARY --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">📈</span>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Executive Summary</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Current overview of your document management system.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 p-8">

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-50 text-gray-600 text-lg">📄</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Total Documents</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ number_format($summary['totalDocuments']) }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600 text-lg">✅</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Completed</p>
                    <h2 class="text-2xl font-bold text-green-600">{{ number_format($summary['completedDocuments']) }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-500 text-lg">⏳</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Pending Review</p>
                    <h2 class="text-2xl font-bold text-amber-500">{{ number_format($summary['reviewDocuments']) }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 text-lg">🗄️</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Archived</p>
                    <h2 class="text-2xl font-bold text-indigo-600">{{ number_format($summary['archivedDocuments']) }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 text-lg">📤</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Assigned</p>
                    <h2 class="text-2xl font-bold text-blue-600">{{ number_format($summary['assignedDocuments']) }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-orange-500 text-lg">↩️</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Returned</p>
                    <h2 class="text-2xl font-bold text-orange-500">{{ number_format($summary['returnedDocuments']) }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600 text-lg">❌</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Rejected</p>
                    <h2 class="text-2xl font-bold text-red-600">{{ number_format($summary['rejectedDocuments']) }}</h2>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 text-lg">📂</div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Repositories</p>
                    <h2 class="text-2xl font-bold text-purple-600">{{ number_format($summary['repositories']) }}</h2>
                </div>
            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- EXECUTIVE INSIGHTS --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">💡</span>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Executive Insights</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Key performance indicators and overall system highlights.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 p-8">

            {{-- Top Office --}}
            <div class="rounded-xl border border-gray-100 p-5 hover:border-indigo-200 hover:shadow-sm transition">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">🏢</div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Top Office</p>
                        <h3 class="text-lg font-bold text-gray-800">{{ $topOffice?->office_name ?? '-' }}</h3>
                        <p class="text-sm text-indigo-600 font-semibold">{{ $topOffice?->documents_count ?? 0 }} Documents</p>
                    </div>
                </div>
            </div>

            {{-- Top Employee --}}
            <div class="rounded-xl border border-gray-100 p-5 hover:border-indigo-200 hover:shadow-sm transition">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-lg">👤</div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Top Employee</p>
                        <h3 class="text-lg font-bold text-gray-800">{{ $topEmployee?->full_name ?? '-' }}</h3>
                        <p class="text-sm text-indigo-600 font-semibold">{{ $topEmployee?->submitted_documents_count ?? 0 }} Documents</p>
                    </div>
                </div>
            </div>

            {{-- Top Repository --}}
            <div class="rounded-xl border border-gray-100 p-5 hover:border-indigo-200 hover:shadow-sm transition">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-lg">📂</div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Top Repository</p>
                        <h3 class="text-lg font-bold text-gray-800">{{ $topRepository?->name ?? '-' }}</h3>
                        <p class="text-sm text-indigo-600 font-semibold">{{ $topRepository?->documents_count ?? 0 }} Documents</p>
                    </div>
                </div>
            </div>

            {{-- Completion Rate --}}
            <div class="rounded-xl border border-gray-100 p-5 hover:border-green-200 hover:shadow-sm transition">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50 text-lg">✅</div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Completion Rate</p>
                        <h3 class="text-2xl font-bold text-green-600">{{ $completionRate }}%</h3>
                    </div>
                </div>
            </div>

            {{-- Busiest Month --}}
            <div class="rounded-xl border border-gray-100 p-5 hover:border-amber-200 hover:shadow-sm transition">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-lg">📅</div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Busiest Month</p>
                        <h3 class="text-lg font-bold text-gray-800">{{ $busiestMonth }}</h3>
                    </div>
                </div>
            </div>

            {{-- Average Documents --}}
            <div class="rounded-xl border border-gray-100 p-5 hover:border-indigo-200 hover:shadow-sm transition">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-lg">📈</div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Avg Documents / Month</p>
                        <h3 class="text-2xl font-bold text-indigo-600">{{ $averageDocuments }}</h3>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- PERFORMANCE OVERVIEW --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">⚡</span>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Performance Overview</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Overall operational efficiency of the document management system.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">

            <div>
                <p class="text-sm font-medium text-gray-500">Completion Rate</p>
                <div class="mt-4">
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-gray-800">{{ $completionRate }}%</span>
                        <span class="text-gray-400">Completed Documents</span>
                    </div>
                    <div class="mt-2 h-3 rounded-full bg-gray-100 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-blue-500" style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">Most Active Office</p>
                <h3 class="mt-3 text-xl font-bold text-gray-900">{{ optional($mostActiveOffice)->office_name ?? 'N/A' }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ optional($mostActiveOffice)->documents_count ?? 0 }} Documents Processed</p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">Most Used Repository</p>
                <h3 class="mt-3 text-xl font-bold text-gray-900">{{ optional($mostUsedRepository)->name ?? 'N/A' }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ optional($mostUsedRepository)->documents_count ?? 0 }} Archived Documents</p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">Average Processing Time</p>
                <h3 class="mt-3 text-xl font-bold text-gray-900">Coming Soon</h3>
                <p class="text-sm text-gray-500 mt-1">This metric will be available after processing-time calculations are implemented.</p>
            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- ANALYTICS VISUALIZATION --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">📊</span>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Analytics Visualization</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Document statistics and workflow trends.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 p-8">

            <div class="rounded-xl border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm">Monthly Document Trend</h3>
                <div class="relative h-72">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

            <div class="rounded-xl border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm">Document Status Distribution</h3>
                <div class="relative h-72">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- REPOSITORY ANALYTICS --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-purple-50 text-purple-600 text-sm">📂</span>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Repository Analytics</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Repository usage based on archived documents.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        <div class="p-8 space-y-5">

            @php
                $highest = max($repositoryAnalytics->pluck('documents_count')->toArray() ?: [1]);
            @endphp

            @foreach($repositoryAnalytics as $repository)
                <div>
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-lg">
                                {{ $repository->icon }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-800">{{ $repository->name }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $repository->documents_count }} {{ Str::plural('Document', $repository->documents_count) }}
                                </div>
                            </div>
                        </div>
                        <div class="text-sm font-semibold text-indigo-600">
                            {{ round(($repository->documents_count / $highest) * 100) }}%
                        </div>
                    </div>
                    <div class="h-2 rounded-full bg-gray-100">
                        <div class="h-2 rounded-full bg-indigo-500" style="width: {{ ($repository->documents_count / $highest) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- OFFICE PERFORMANCE --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-sm">🏢</span>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Office Performance</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Documents processed by each office.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        <div class="p-8 space-y-5">

            @php
                $highestOffice = max($officePerformance->pluck('documents_count')->toArray() ?: [1]);
            @endphp

            @foreach($officePerformance as $office)
                <div>
                    <div class="flex justify-between mb-2">
                        <div>
                            <div class="text-sm font-semibold text-gray-800">{{ $office->office_name }}</div>
                            <div class="text-xs text-gray-500">
                                {{ $office->documents_count }} {{ Str::plural('Document', $office->documents_count) }}
                            </div>
                        </div>
                        <div class="text-sm font-semibold text-indigo-600">
                            {{ round(($office->documents_count / $highestOffice) * 100) }}%
                        </div>
                    </div>
                    <div class="h-2 rounded-full bg-gray-100">
                        <div class="h-2 rounded-full bg-indigo-500" style="width: {{ ($office->documents_count / $highestOffice) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- EMPLOYEE PERFORMANCE --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 text-sm">👤</span>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Employee Performance</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Top employees based on submitted documents.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        <div class="p-8 space-y-5">

            @php
                $highestEmployee = max($employeePerformance->pluck('submitted_documents_count')->toArray() ?: [1]);
            @endphp

            @foreach($employeePerformance as $employee)
                <div>
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-semibold text-indigo-600">
                                {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-800">{{ $employee->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $employee->submitted_documents_count }} Documents Submitted</div>
                            </div>
                        </div>
                        <div class="text-sm font-semibold text-indigo-600">
                            {{ round(($employee->submitted_documents_count / $highestEmployee) * 100) }}%
                        </div>
                    </div>
                    <div class="h-2 rounded-full bg-gray-100">
                        <div class="h-2 rounded-full bg-indigo-500" style="width: {{ ($employee->submitted_documents_count / $highestEmployee) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    new Chart(
        document.getElementById('monthlyChart'),
        {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Documents',
                    data: @json($monthlyDocuments),
                    borderColor: '#6366F1',
                    backgroundColor: 'rgba(99,102,241,.12)',
                    fill: true,
                    tension: .35,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#6366F1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        }
    );

    new Chart(
        document.getElementById('statusChart'),
        {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($statusDistribution)),
                datasets: [{
                    data: @json(array_values($statusDistribution)),
                    backgroundColor: ['#FACC15', '#3B82F6', '#10B981', '#F97316', '#EF4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: { legend: { position: 'bottom' } }
            }
        }
    );

});
</script>

</x-layouts.admin-layout>