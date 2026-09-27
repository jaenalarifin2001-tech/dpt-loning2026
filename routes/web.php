<?php

use App\Http\Controllers\DptController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminImportController;

Route::get('/', [DptController::class, 'index'])->name('dpt.index');

Route::post('/cari', [DptController::class, 'cari'])
    ->middleware('throttle:10,1') // max 10 request/menit per IP
    ->name('dpt.cari');
	

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/import', [AdminImportController::class, 'index'])->name('import.index');
    Route::post('/import', [AdminImportController::class, 'upload'])->name('import.upload');
    Route::get('/import/template', [AdminImportController::class, 'template'])->name('import.template');
});