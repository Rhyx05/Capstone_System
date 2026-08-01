<form method="GET" action="{{ route('user.documents') }}">

    <div class="bg-white rounded-xl shadow border p-6">

        <div class="grid grid-cols-4 gap-4">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search title or tracking code..."
                class="col-span-2 rounded-lg border-gray-300">

            <select
                name="category"
                class="rounded-lg border-gray-300">

                <option value="">All Categories</option>

                <option value="Purchase Request"
                    @selected(request('category')=='Purchase Request')>
                    Purchase Request
                </option>

                <option value="Memorandum"
                    @selected(request('category')=='Memorandum')>
                    Memorandum
                </option>

                <option value="Letter"
                    @selected(request('category')=='Letter')>
                    Letter
                </option>

                <option value="Resolution"
                    @selected(request('category')=='Resolution')>
                    Resolution
                </option>

            </select>

            <select
                name="status"
                class="rounded-lg border-gray-300">

                <option value="">All Status</option>

                <option value="for_review"
                    @selected(request('status')=='for_review')>
                    For Review
                </option>

                <option value="approved"
                    @selected(request('status')=='approved')>
                    Approved
                </option>

                <option value="returned"
                    @selected(request('status')=='returned')>
                    Returned
                </option>

                <option value="archived"
                    @selected(request('status')=='archived')>
                    Archived
                </option>

            </select>

        </div>

        <div class="mt-5 flex justify-end gap-3">

            <a href="{{ route('user.documents') }}"
                class="px-5 py-2 border rounded-lg hover:bg-gray-100">

                Reset

            </a>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                Search

            </button>

        </div>

    </div>

</form>