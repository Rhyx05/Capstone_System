<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\ElectronicFilingCategory;

class AnalyticsController extends Controller
{
    public function index()
    {
        $summary = [

            'totalDocuments' => Document::count(),

            'completedDocuments' => Document::where('status', 'completed')->count(),

            'assignedDocuments' => Document::where('status', 'assigned')->count(),

            'returnedDocuments' => Document::where('status', 'returned')->count(),

            'reviewDocuments' => Document::where('status', 'for_review')->count(),

            'rejectedDocuments' => Document::where('status', 'rejected')->count(),

            'repositories' => ElectronicFilingCategory::count(),

            'archivedDocuments' => Document::whereNotNull('filing_category_id')->count(),

        ];

        /*
|--------------------------------------------------------------------------
| Performance Overview
|--------------------------------------------------------------------------
*/

$completionRate = $summary['totalDocuments'] > 0
    ? round(($summary['completedDocuments'] / $summary['totalDocuments']) * 100)
    : 0;

$mostActiveOffice = \App\Models\Office::withCount('documents')
    ->orderByDesc('documents_count')
    ->first();

$mostUsedRepository = ElectronicFilingCategory::withCount('documents')
    ->orderByDesc('documents_count')
    ->first();

    /*
|--------------------------------------------------------------------------
| Monthly Document Trend
|--------------------------------------------------------------------------
*/

$monthlyDocuments = [];

for ($i = 1; $i <= 12; $i++) {

    $monthlyDocuments[] = Document::whereYear('created_at', now()->year)
        ->whereMonth('created_at', $i)
        ->count();

}

/*
|--------------------------------------------------------------------------
| Document Status Distribution
|--------------------------------------------------------------------------
*/

$statusDistribution = [

    'For Review' => Document::where('status', 'for_review')->count(),

    'Assigned' => Document::where('status', 'assigned')->count(),

    'Completed' => Document::where('status', 'completed')->count(),

    'Returned' => Document::where('status', 'returned')->count(),

    'Rejected' => Document::where('status', 'rejected')->count(),

];

    /*
    |--------------------------------------------------------------------------
    | Repository Analytics
    |--------------------------------------------------------------------------
    */


$repositoryAnalytics = ElectronicFilingCategory::withCount('documents')
    ->orderByDesc('documents_count')
    ->get();

    /*
|--------------------------------------------------------------------------
| Office Performance
|--------------------------------------------------------------------------
*/

$officePerformance = \App\Models\Office::withCount('documents')
    ->orderByDesc('documents_count')
    ->get();

    /*
|--------------------------------------------------------------------------
| Employee Performance
|--------------------------------------------------------------------------
*/

$employeePerformance = \App\Models\User::where('role', 'user')
    ->withCount('submittedDocuments')
    ->orderByDesc('submitted_documents_count')
    ->take(10)
    ->get();

    /*
|--------------------------------------------------------------------------
| Executive KPI
|--------------------------------------------------------------------------
*/

$topEmployee = $employeePerformance->first();

$topOffice = $officePerformance->first();

$topRepository = $repositoryAnalytics->first();

$busiestMonthIndex = collect($monthlyDocuments)->search(max($monthlyDocuments));

$months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];

$busiestMonth = $months[$busiestMonthIndex] ?? '-';

$averageDocuments = round(array_sum($monthlyDocuments) / 12);


return view('admin.analytics.index', compact(
    'summary',
    'completionRate',
    'mostActiveOffice',
    'mostUsedRepository',
    'monthlyDocuments',
    'statusDistribution',
    'repositoryAnalytics',
    'officePerformance',
      'employeePerformance',
          'topEmployee',
    'topOffice',
    'topRepository',
    'busiestMonth',
    'averageDocuments'
));
    }
    
}