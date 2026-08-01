<div class="grid grid-cols-4 gap-6">

    <div class="bg-white rounded-xl shadow border p-6">

        <p class="text-gray-500">

            Incoming

        </p>

        <h2 class="text-3xl font-bold mt-2">

            {{ $incomingCount }}

        </h2>

    </div>

    <div class="bg-white rounded-xl shadow border p-6">

        <p class="text-blue-600">

            Assigned

        </p>

        <h2 class="text-3xl font-bold mt-2">

            {{ $assignedCount }}

        </h2>

    </div>

    <div class="bg-white rounded-xl shadow border p-6">

        <p class="text-green-600">

            Completed

        </p>

        <h2 class="text-3xl font-bold mt-2">

            {{ $completedCount }}

        </h2>

    </div>

    <div class="bg-white rounded-xl shadow border p-6">

        <p class="text-purple-600">

            Archived

        </p>

        <h2 class="text-3xl font-bold mt-2">

            {{ $archivedCount }}

        </h2>

    </div>

</div>