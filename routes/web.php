<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicApplicantController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicantManagementController;
use App\Http\Controllers\ProgramModuleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Public Routes (QR Code Entry Point for Applicants)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicApplicantController::class, 'showForm'])->name('home');

Route::get('/applicant/register', [PublicApplicantController::class, 'showForm'])->name('public.register');
Route::post('/applicant/register', [PublicApplicantController::class, 'store'])->name('public.register.store');
Route::get('/applicant/confirmation/{applicationNumber}', [PublicApplicantController::class, 'confirmation'])->name('public.confirmation');
Route::get('/api/geography/regions', [\App\Http\Controllers\GeographyController::class, 'regions']);
Route::get('/api/geography/provinces', [\App\Http\Controllers\GeographyController::class, 'provinces']);
Route::get('/api/geography/cities-municipalities', [\App\Http\Controllers\GeographyController::class, 'citiesMunicipalities']);
Route::get('/api/geography/barangays', [\App\Http\Controllers\GeographyController::class, 'barangays']);

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Management Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Applicant Directory & Records
    Route::get('/applicants', [ApplicantManagementController::class, 'index'])->name('applicants.index');
    Route::get('/applicants/{id}', [ApplicantManagementController::class, 'show'])->name('applicants.show');
    Route::get('/applicants/{id}/edit', [ApplicantManagementController::class, 'edit'])->name('applicants.edit');
    Route::put('/applicants/{id}', [ApplicantManagementController::class, 'update'])->name('applicants.update');
    Route::delete('/applicants/{id}', [ApplicantManagementController::class, 'destroy'])->name('applicants.destroy');
    Route::get('/applicants/{id}/print', [ApplicantManagementController::class, 'print'])->name('applicants.print');

    // Program Modules (GIP, Job, SPES)
    Route::get('/gip', [ProgramModuleController::class, 'gip'])->name('gip.index');
    Route::get('/job', [ProgramModuleController::class, 'job'])->name('job.index');
    Route::get('/spes', [ProgramModuleController::class, 'spes'])->name('spes.index');

    // Application Actions
    Route::get('/applications/{id}', [ProgramModuleController::class, 'showApplication'])->name('applications.show');
    Route::get('/applications/{id}/edit', [ProgramModuleController::class, 'editApplication'])->name('applications.edit');
    Route::put('/applications/{id}', [ProgramModuleController::class, 'updateApplication'])->name('applications.update');
    Route::patch('/applications/{id}/status', [ProgramModuleController::class, 'updateStatus'])->name('applications.update-status');
    Route::delete('/applications/{id}', [ProgramModuleController::class, 'destroyApplication'])->name('applications.destroy');
    Route::get('/applications/{id}/print', [ProgramModuleController::class, 'printApplication'])->name('applications.print');

    // Reports Suite
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [ReportController::class, 'printReport'])->name('reports.print');

    // Municipal QR Poster & Generator
    Route::get('/qr-code', [SettingsController::class, 'qrCode'])->name('qr.index');

    // Administrative Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/users', [SettingsController::class, 'storeUser'])->name('users.store');
    Route::put('/settings/users/{user}', [SettingsController::class, 'updateUser'])->name('users.update');
    Route::put('/settings/users/{user}/password', [SettingsController::class, 'updateUserPassword'])->name('users.update-password');
    Route::delete('/settings/users/{user}', [SettingsController::class, 'destroyUser'])->name('users.destroy');
});
