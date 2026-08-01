<x-layouts.employee-layout>

    {{-- Page Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-900">
            My Documents
        </h1>

        <p class="mt-2 text-gray-500">
            View and track all documents you have submitted.
        </p>

    </div>

<x-documents.statistics
    :submittedCount="$submittedCount"
    :reviewCount="$reviewCount"
    :approvedCount="$approvedCount"
    :returnedCount="$returnedCount"
    />

    {{-- Filters --}}
    <div class="mt-6">

        <x-documents.filters />

    </div>

    {{-- Documents Table --}}
    <div class="mt-6">

        <x-documents.table :documents="$documents" />

    </div>

</x-layouts.employee-layout>