@props([
    'submittedCount' => 0,
    'reviewCount' => 0,
    'approvedCount' => 0,
    'returnedCount' => 0,
])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total Submitted -->
    <div class="bg-white rounded-xl shadow border p-6">

        <p class="text-gray-500">
            Submitted
        </p>

        <h2 class="text-3xl font-bold mt-2">
            {{ $submittedCount }}
        </h2>

    </div>

    <!-- For Review -->
    <div class="bg-white rounded-xl shadow border p-6">

        <p class="text-yellow-600">
            For Review
        </p>

        <h2 class="text-3xl font-bold mt-2">
            {{ $reviewCount }}
        </h2>

    </div>

    <!-- Approved -->
    <div class="bg-white rounded-xl shadow border p-6">

        <p class="text-green-600">
            Approved
        </p>

        <h2 class="text-3xl font-bold mt-2">
            {{ $approvedCount }}
        </h2>

    </div>

    <!-- Returned -->
    <div class="bg-white rounded-xl shadow border p-6">

        <p class="text-red-600">
            Returned or Rejected
        </p>

        <h2 class="text-3xl font-bold mt-2">
            {{ $returnedCount }}
        </h2>

    </div>

</div>