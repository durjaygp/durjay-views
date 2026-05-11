<?php

use Illuminate\Support\Facades\Route;
use Durjaygp\DurjayViews\Http\Controllers\DurjayViewsController;

$middleware = config('durjay-views.middleware', ['web']);
$requireAuth = config('durjay-views.require_auth', false);
$path        = config('durjay-views.path', 'durjay-views');

// Automatically append 'auth' if require_auth is enabled and not already present
if ($requireAuth && ! in_array('auth', $middleware)) {
    $middleware[] = 'auth';
}

Route::middleware($middleware)->group(function () use ($path) {

    // Public / Auth-protected stats dashboard
    Route::get("/{$path}/stats", [DurjayViewsController::class, 'index'])
        ->name('durjay-views.stats');

    // Admin route — only available when 'admin' middleware is in the stack
    // Users can add their own 'admin' middleware in config/durjay-views.php
    Route::get("/{$path}/admin", [DurjayViewsController::class, 'admin'])
        ->name('durjay-views.admin');

});
