<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\ElectronicFilingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ElectronicFilingController extends Controller
{
    /**
     * Electronic Filing Dashboard
     */
public function index()
{
    $repositories = ElectronicFilingCategory::withCount('documents')
        ->orderBy('name')
        ->get();

    $totalRepositories = $repositories->count();

    $archivedDocuments = Document::whereNotNull('filing_category_id')
        ->count();

    $todayArchives = Document::whereNotNull('filing_category_id')
        ->whereDate('updated_at', today())
        ->count();

    $storageUsed = Document::whereNotNull('filing_category_id')
        ->sum('file_size');

    /*
    |--------------------------------------------------------------------------
    | Documents Waiting for Filing
    |--------------------------------------------------------------------------
    */
$pendingDocuments = Document::with([
        'submittedBy',
        'office',
    ])
    ->whereNull('filing_category_id')
    ->where('status', 'completed')
    ->latest()
    ->paginate(10);

    return view('admin.filing.index', [
        'repositories'       => $repositories,
        'totalRepositories'  => $totalRepositories,
        'archivedDocuments'  => $archivedDocuments,
        'todayArchives'      => $todayArchives,
        'storageUsed'        => $storageUsed,
        'pendingDocuments'   => $pendingDocuments,
    ]);
}
    /**
     * Create Repository
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:electronic_filing_categories,name',
            'description' => 'nullable|string|max:500',
            'icon'        => 'required|string|max:10',
            'color'       => 'required|string|max:30',
        ]);

        ElectronicFilingCategory::create($validated);

        return back()->with(
            'success',
            'Repository created successfully.'
        );
    }

    /**
     * Update Repository
     */
    public function update(Request $request, ElectronicFilingCategory $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:electronic_filing_categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon'        => 'required|string|max:10',
            'color'       => 'required|string|max:30',
        ]);

        $category->update($validated);

        return back()->with(
            'success',
            'Repository updated successfully.'
        );
    }

    /**
     * Delete Repository
     */
    public function destroy(ElectronicFilingCategory $category)
    {
        if ($category->documents()->exists()) {

            return back()->with(
                'error',
                'Repository cannot be deleted because it contains archived documents.'
            );
        }

        $category->delete();

        return back()->with(
            'success',
            'Repository deleted successfully.'
        );
    }

    /**
     * Repository Documents
     */
    public function repository(ElectronicFilingCategory $category)
    {
        $documents = Document::with([
                'submittedBy',
                'office',
            
            ])
            ->where('filing_category_id', $category->id)
            ->latest('updated_at')
            ->paginate(10);

        return view('admin.filing.repository', [
            'category'  => $category,
            'documents' => $documents,
        ]);
    }

    public function show(Document $document)
{
    $document->load([
        'submittedBy',
        'office',
        'receiverOffice',
        'assignedUser',
        'approver',
        'reviewer',
        'logs.user',
    ]);

    $repositories = ElectronicFilingCategory::orderBy('name')->get();

    return view('admin.filing.show', [
        'document' => $document,
        'repositories' => $repositories,
    ]);
}

public function destroyPending(Document $document)
{
    if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
        Storage::disk('public')->delete($document->file_path);
    }

    $document->delete();

    return redirect()
        ->route('admin.filing.index')
        ->with('success', 'Document deleted successfully.');
}

public function repositoryShow(Document $document)
{
    $document->load([
        'submittedBy',
        'office',
        'receiverOffice',
        'assignedUser',
        'approver',
        'reviewer',
        'logs.user',
        'filingCategory',
    ]);

    return view(
        'admin.filing.repository-show',
        compact('document')
    );
}

}