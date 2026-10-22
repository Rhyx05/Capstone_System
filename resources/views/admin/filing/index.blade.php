<x-layouts.admin-layout>

<div>

    {{-- ========================================================= --}}
    {{-- ALERT MESSAGES --}}
    {{-- ========================================================= --}}

    @if(session('success'))
        <div class="max-w-6xl mx-auto mb-4 p-4 rounded-xl bg-green-100 border border-green-200 text-green-700 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-6xl mx-auto mb-4 p-4 rounded-xl bg-red-100 border border-red-200 text-red-700 text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-6xl mx-auto mb-4 p-4 rounded-xl bg-red-100 border border-red-200 text-red-700 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ========================================================= --}}
    {{-- REPOSITORIES --}}
    {{-- ========================================================= --}}

    @include('admin.filing.partials.electronicfiling')

</div>

{{-- ========================================================= --}}
{{-- MODALS --}}
{{-- ========================================================= --}}

@include('admin.filing.partials.create-modal')

@include('admin.filing.partials.edit-modal')

@include('admin.filing.partials.delete-modal')

{{-- ========================================================= --}}
{{-- PAGE SCRIPTS --}}
{{-- ========================================================= --}}

<script>

function openCreateCategoryModal() {

    document.getElementById('createRepositoryModal').classList.remove('hidden');

}

function closeCreateCategoryModal() {

    document.getElementById('createRepositoryModal').classList.add('hidden');

}

function openEditCategoryModal(id, name, description, icon, color) {

    const modal = document.getElementById('editRepositoryModal');

    modal.classList.remove('hidden');

    document.getElementById('edit-name').value = name;
    document.getElementById('edit-description').value = description;
    document.getElementById('edit-icon').value = icon;
    document.getElementById('edit-color').value = color;

    document.getElementById('editForm').action =
        "{{ url('admin/filing') }}/" + id;

}

function closeEditCategoryModal() {

    document.getElementById('editRepositoryModal').classList.add('hidden');

}

function openDeleteRepositoryModal(id, name) {
    const modal = document.getElementById('deleteRepositoryModal');
    const form = document.getElementById('deleteRepositoryForm');

    // Same URL structure as the working edit function.
    form.action = "{{ url('admin/filing') }}/" + id;

    document.getElementById('delete-repository-name').textContent = name;

    modal.classList.remove('hidden');
}

function closeDeleteRepositoryModal() {
    document.getElementById('deleteRepositoryModal').classList.add('hidden');
}

function openArchiveDocumentModal(documentId) {

    document
        .getElementById('archiveDocumentModal')
        .classList.remove('hidden');

    document
        .getElementById('archiveDocumentForm')
        .action =
        "{{ url('admin/documents') }}/" +
        documentId +
        "/archive";

}

function closeArchiveDocumentModal() {

    document
        .getElementById('archiveDocumentModal')
        .classList.add('hidden');

}

</script>

</x-layouts.admin-layout>