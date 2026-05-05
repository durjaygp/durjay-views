<?php

use Illuminate\Support\Facades\Route;
use Durjaygp\DurjayViews\Http\Controllers\DurjayViewsController;

Route::middleware(['web'])->group(function () {
    Route::get('/durjay-views/stats', [DurjayViewsController::class, 'index'])->name('durjay-views.stats');
});
