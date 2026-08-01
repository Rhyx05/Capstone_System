<x-layouts.admin-layout>

<div class="space-y-8">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-gray-900">
                Electronic Filing
            </h1>

            <p class="mt-2 text-gray-500">
                Manage electronic filing categories and document repositories.
            </p>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- STATISTICS --}}
    {{-- ========================================================= --}}

    @include('admin.filing.partials.statistics')

    {{-- ========================================================= --}}
    {{-- REPOSITORIES --}}
    {{-- ========================================================= --}}

    @include('admin.filing.partials.repositories')

    {{-- ========================================================= --}}
    {{-- DOCUMENTS READY FOR FILING --}}
    {{-- ========================================================= --}}

    @include('admin.filing.partials.pending-documents')

    

</div>

{{-- ========================================================= --}}
{{-- MODALS --}}
{{-- ========================================================= --}}

@include('admin.filing.partials.create-modal')

@include('admin.filing.partials.edit-modal')

@include('admin.filing.modals.delete')

@include('admin.filing.modals.archive-document')

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

function openDeleteCategoryModal(id, name) {

    document
        .getElementById('deleteRepositoryModal')
        .classList.remove('hidden');

    document
        .getElementById('deleteRepositoryName')
        .innerText = name;

    document
        .getElementById('deleteForm')
        .action = "{{ url('admin/filing') }}/" + id;

}

function closeDeleteCategoryModal() {

    document
        .getElementById('deleteRepositoryModal')
        .classList.add('hidden');

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