<x-layouts.admin-layout>

<div class="space-y-6">

    {{-- Page Header --}}
    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Forward Document
        </h1>

        <p class="text-gray-500 mt-1">
            Send a document directly to a designated employee.
        </p>

    </div>

    {{-- Success Message --}}
    @if(session('success'))

        <div class="rounded-lg bg-green-100 border border-green-300 p-4 text-green-700">

            {{ session('success') }}

        </div>

    @endif

    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-lg bg-red-100 border border-red-300 p-4 text-red-700">

            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    {{-- Form --}}
    <div class="bg-white rounded-xl shadow p-6">

        <form method="POST" action="{{ route('admin.submit.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Document Title
                </label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full rounded-lg border-gray-300"
                    required
                    autofocus>
            </div>

            {{-- Category --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Category
                </label>
                <input
                    type="text"
                    name="category"
                    value="{{ old('category') }}"
                    placeholder="e.g. Memorandum, Report, Circular"
                    class="w-full rounded-lg border-gray-300"
                    required>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Description <span class="text-gray-400">(optional)</span>
                </label>
                <textarea
                    name="description"
                    rows="3"
                    class="w-full rounded-lg border-gray-300">{{ old('description') }}</textarea>
            </div>

            {{-- Send To --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Send To
                </label>
                <select name="sent_to" class="w-full rounded-lg border-gray-300" required>
                    <option value="">Select personnel</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('sent_to') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->first_name }} {{ $employee->last_name }}
                            @if($employee->office)
                                — {{ $employee->office->office_name }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- File --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Attach File
                </label>
                <input
                    type="file"
                    name="file"
                    class="w-full rounded-lg border-gray-300"
                    required>
                <p class="text-xs text-gray-400 mt-1">
                    Accepted: PDF, JPG, PNG, DOCX — Max 10MB
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.documents') }}"
                   class="px-6 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                    Forward Document
                </button>
            </div>

        </form>

    </div>

    {{-- Forwarded Documents Table --}}
    <div class="bg-white rounded-xl shadow">

        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800">
                Forwarded Documents
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                Documents you've sent directly to personnel.
            </p>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-left">Tracking</th>
                        <th class="p-4 text-left">Title</th>
                        <th class="p-4 text-left">Sent To</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Date Sent</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($forwardedDocuments as $doc)

                    <tr class="border-t hover:bg-gray-50">

                        <td class="p-4 font-semibold text-blue-700">
                            {{ $doc->tracking_code }}
                        </td>

                        <td class="p-4">
                            {{ $doc->title }}
                        </td>

                        <td class="p-4">
                            {{ $doc->sentTo->first_name }} {{ $doc->sentTo->last_name }}
                        </td>

                        <td class="p-4 text-center">
                            <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                                {{ ucwords(str_replace('_', ' ', $doc->status)) }}
                            </span>
                        </td>

                        <td class="p-4 text-center">
                            {{ $doc->submission_date->format('M d, Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-500">
                            No documents forwarded yet.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-5 border-t">
            {{ $forwardedDocuments->links() }}
        </div>

    </div>

</div>

</x-layouts.admin-layout>