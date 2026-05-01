<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterTenantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperDashboardController;
use App\Http\Controllers\Tenant\MemberController;
use App\Http\Controllers\Tenant\TransactionController;
use App\Http\Controllers\Tenant\SubscriptionController;
use App\Http\Controllers\Tenant\MeetingController;
use App\Http\Controllers\Tenant\ProjectController;
use App\Http\Controllers\Tenant\DocumentController;
use App\Http\Controllers\Tenant\ReportController;

// Public
Route::get('/', fn() => redirect()->route('login'));
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// Guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterTenantController::class, 'show'])->name('register');
    Route::post('/register', [RegisterTenantController::class, 'register']);
});

// Authenticated
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    // SuperAdmin
    Route::middleware(['role:super_admin'])->prefix('super')->name('super.')->group(function () {
        Route::get('/dashboard', [SuperDashboardController::class, 'index'])->name('dashboard');
    });

    // Tenant modules
    Route::middleware(['tenant'])->group(function () {
        Route::resource('members', MemberController::class);
        Route::resource('transactions', TransactionController::class);
        Route::resource('subscriptions', SubscriptionController::class)->except(['edit','update']);
        Route::resource('meetings', MeetingController::class);
        Route::post('/meetings/{meeting}/attend', [MeetingController::class, 'attend'])->name('meetings.attend');
        Route::resource('projects', ProjectController::class);
        Route::resource('documents', DocumentController::class)->except(['show','edit','update']);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/members', [ReportController::class, 'members'])->name('reports.members');
        Route::get('/reports/finance', [ReportController::class, 'finance'])->name('reports.finance');
    });
});
