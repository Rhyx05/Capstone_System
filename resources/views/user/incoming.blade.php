<x-layouts.employee-layout>

{{-- ========================================================= --}}
{{-- SUCCESS MESSAGE --}}
{{-- ========================================================= --}}

@if(session('success'))

<div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-6 py-4 flex items-center gap-3">

    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">

        ✅

    </div>

    <div>

        <p class="font-semibold text-green-800">

            Success

        </p>

        <p class="text-green-700">

            {{ session('success') }}

        </p>

    </div>

</div>

@endif

<div>

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-900">

            Incoming Documents

        </h1>

        <p class="mt-2 text-gray-500">

            Documents assigned to you by the Administrator.

        </p>

    </div>



    <div class="mt-6">

        <x-incoming.filters/>

    </div>

    <div class="mt-6">

        <x-incoming.table
            :documents="$documents"
        />

    </div>

</div>

</x-layouts.employee-layout>