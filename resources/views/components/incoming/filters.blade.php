<div class="bg-white rounded-xl shadow border p-6">

    <form
        method="GET"
        class="grid grid-cols-3 gap-4">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search..."
            class="rounded-lg border-gray-300">

        <select
            name="priority"
            class="rounded-lg border-gray-300">

            <option value="">All Priorities</option>

            <option value="Urgent" {{ request('priority') == 'Urgent' ? 'selected' : '' }}>Urgent</option>

            <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>

            <option value="Normal" {{ request('priority') == 'Normal' ? 'selected' : '' }}>Normal</option>

        </select>

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

            Filter

        </button>

    </form>

</div>