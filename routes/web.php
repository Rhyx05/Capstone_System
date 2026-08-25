<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\SubmitDocumentController;
use App\Http\Controllers\User\MyDocumentsController;
use App\Http\Controllers\User\IncomingDocumentsController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\ElectronicFilingController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\NotificationController;


/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return match (Auth::user()->role) {

        'admin' => redirect()->route('admin.dashboard'),

        'record_keeper' => redirect()->route('record.dashboard'),

        default => redirect()->route('user.dashboard'),

    };

});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
/*
|--------------------------------------------------------------------------
| Employee Module
|--------------------------------------------------------------------------
*/

Route::middleware(['role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [UserDashboardController::class, 'index']
        )->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Submit Document
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/submit',
            [SubmitDocumentController::class, 'create']
        )->name('submit');

        Route::post(
            '/submit',
            [SubmitDocumentController::class, 'store']
        )->name('submit.store');

        /*
        |--------------------------------------------------------------------------
        | My Documents
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/documents',
            [MyDocumentsController::class, 'index']
        )->name('documents');

        Route::get(
            '/documents/{document}',
            [MyDocumentsController::class, 'show']
        )->name('documents.show');

        /*
        |--------------------------------------------------------------------------
        | Received Documents
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/received',
            [MyDocumentsController::class, 'received']
        )->name('received');

        /*
        |--------------------------------------------------------------------------
        | Incoming Documents
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/incoming',
            [IncomingDocumentsController::class, 'index']
        )->name('incoming');

        Route::get(
            '/incoming/{document}',
            [IncomingDocumentsController::class, 'show']
        )->name('incoming.show');
        /*
        |--------------------------------------------------------------------------
        | History Log
        |--------------------------------------------------------------------------
        */

        Route::get(
    '/history',
    [App\Http\Controllers\User\HistoryController::class, 'index']
)->name('history');

        /*
        |--------------------------------------------------------------------------
        | Document Processing
        |--------------------------------------------------------------------------
        */
Route::post(
    '/incoming/{document}/receive',
    [IncomingDocumentsController::class, 'receive']
)->name('incoming.receive');

Route::post(
    '/incoming/{document}/submit',
    [IncomingDocumentsController::class, 'submit']
)->name('incoming.submit');

Route::post(
    '/incoming/{document}/forward',
    [IncomingDocumentsController::class, 'forward']
)->name('incoming.forward');

Route::post(
    '/incoming/{document}/reject',
    [IncomingDocumentsController::class, 'reject']
)->name('incoming.reject');

Route::post(
    '/incoming/{document}/complete',
    [IncomingDocumentsController::class, 'complete']
)->name('incoming.complete');


    /*
|--------------------------------------------------------------------------
| User Notifications
|--------------------------------------------------------------------------
*/

Route::get(
    '/notifications/live',
    [\App\Http\Controllers\User\NotificationController::class, 'live']
)->name('notifications.live');

Route::prefix('notifications')
    ->name('notifications.')
    ->group(function () {

        Route::get(
            '/',
            [\App\Http\Controllers\User\NotificationController::class, 'index']
        )->name('index');

        Route::post(
            '/{notification}/read',
            [\App\Http\Controllers\User\NotificationController::class, 'markAsRead']
        )->name('read');

        Route::post(
            '/read-all',
            [\App\Http\Controllers\User\NotificationController::class, 'markAllAsRead']
        )->name('readAll');

    });

        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/settings',
            'user.settings'
        )->name('settings');

    });

/*
|--------------------------------------------------------------------------
| Administrator Module
|--------------------------------------------------------------------------
*/

Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard',
            [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/forward', [DocumentController::class, 'createForward'])
            ->name('submit');

        Route::post('/forward', [DocumentController::class, 'storeForward'])
            ->name('submit.store');

        Route::view('/incoming', 'admin.incoming')
            ->name('incoming');

        Route::view('/users', 'admin.users')
            ->name('users');

            Route::get(
    '/audit/document/{document}',
    [App\Http\Controllers\Admin\AuditController::class, 'documentDetails']
)->name('audit.document');

Route::get(
    '/audit/{document}',
    [AuditController::class, 'timeline']
)->name('audit.timeline');

Route::get(
    '/analytics',
    [AnalyticsController::class, 'index']
)->name('analytics');

Route::get(
    '/notifications/live',
    [NotificationController::class, 'live']
)->name('notifications.live');

/*
|--------------------------------------------------------------------------
| Notification
|--------------------------------------------------------------------------
*/

Route::prefix('notifications')
    ->name('notifications.')
    ->group(function () {

        Route::get(
            '/',
            [NotificationController::class, 'index']
        )->name('index');

        Route::post(
            '/{notification}/read',
            [NotificationController::class, 'markAsRead']
        )->name('read');

        Route::post(
            '/read-all',
            [NotificationController::class, 'markAllAsRead']
        )->name('readAll');

    });

/*
|--------------------------------------------------------------------------
| User Management
|--------------------------------------------------------------------------
*/

Route::resource('users', UserManagementController::class)
    ->only(['index', 'show', 'destroy']);

Route::post(
    'users/{user}/activate',
    [UserManagementController::class, 'activate']
)->name('users.activate');

Route::post(
    'users/{user}/deactivate',
    [UserManagementController::class, 'deactivate']
)->name('users.deactivate');

/*
|--------------------------------------------------------------------------
| Electronic Filing Category
|--------------------------------------------------------------------------
*/

Route::prefix('filing')
    ->name('filing.')
    ->group(function () {

        Route::get(
            '/',
            [ElectronicFilingController::class, 'index']
        )->name('index');

        
Route::get(
    '/document/{document}',
    [ElectronicFilingController::class, 'show']
)->name('show');

Route::delete(
    '/pending/{document}',
    [ElectronicFilingController::class, 'destroyPending']
)->name('pending.destroy');

Route::get(
    '/repository/document/{document}',
    [ElectronicFilingController::class, 'repositoryShow']
)->name('repository.document.show');

        Route::post(
            '/',
            [ElectronicFilingController::class, 'store']
        )->name('store');

        Route::put(
            '/{category}',
            [ElectronicFilingController::class, 'update']
        )->name('update');

        Route::delete(
            '/{category}',
            [ElectronicFilingController::class, 'destroy']
        )->name('destroy');

        Route::get(
    '/{category}/repository',
    [ElectronicFilingController::class, 'repository']
)->name('repository');

Route::post(
    '/documents/{document}/archive',
    [DocumentController::class, 'archive']
)->name('documents.archive');


    });


/*
|--------------------------------------------------------------------------
| Announcement Management
|--------------------------------------------------------------------------
*/

Route::get(
    '/announcements',
    [AnnouncementController::class, 'index']
)->name('announcements');

Route::get(
    '/announcements/create',
    [AnnouncementController::class, 'create']
)->name('announcements.create');

Route::post(
    '/announcements',
    [AnnouncementController::class, 'store']
)->name('announcements.store');

Route::get(
    '/announcements/{announcement}/edit',
    [AnnouncementController::class, 'edit']
)->name('announcements.edit');

Route::put(
    '/announcements/{announcement}',
    [AnnouncementController::class, 'update']
)->name('announcements.update');

Route::delete(
    '/announcements/{announcement}',
    [AnnouncementController::class, 'destroy']
)->name('announcements.destroy');

Route::get('/audit',
    [AuditController::class, 'index'])
    ->name('audit');

        Route::view('/settings', 'admin.settings')
            ->name('settings');

        /*
        |--------------------------------------------------------------------------
        | Document Review Module
        |--------------------------------------------------------------------------
        */

        Route::get('/documents',
            [DocumentController::class, 'index'])
            ->name('documents');

        Route::get('/documents/{document}',
            [DocumentController::class, 'show'])
            ->name('documents.show');

        Route::post('/documents/{document}/approve',
            [DocumentController::class, 'approve'])
            ->name('documents.approve');

        Route::post('/documents/{document}/approve-route',
            [DocumentController::class, 'approveAndRoute'])
            ->name('documents.approve-route');

        Route::post('/documents/{document}/return',
            [DocumentController::class, 'returnDocument'])
            ->name('documents.return');

    });

});

require __DIR__.'/auth.php';