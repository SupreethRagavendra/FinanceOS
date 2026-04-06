<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SummaryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and are assigned
| the "api" middleware group. They are used for Chart.js data fetching.
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/summary', [SummaryController::class, 'summary']);
    Route::get('/category-totals', [SummaryController::class, 'categoryTotals']);
    Route::get('/monthly-trends', [SummaryController::class, 'monthlyTrends']);
});
