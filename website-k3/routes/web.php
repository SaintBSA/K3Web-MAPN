<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

    // Rute untuk Laporan (yang juga membutuhkan otorisasi role)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    });

    Route::middleware(['role:spv'])->group(function () {
        Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
    });

    // Rute yang dapat diakses oleh Admin dan SPV
    Route::middleware(['role:admin,spv'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
    });
});Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Rute untuk Laporan (yang juga membutuhkan otorisasi role)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    });

    Route::middleware(['role:spv'])->group(function () {
        Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
    });

    // Rute yang dapat diakses oleh Admin dan SPV
    Route::middleware(['role:admin,spv'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
    });
});
