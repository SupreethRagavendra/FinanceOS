<?php

/**
 * SummaryController - API endpoints for Chart.js dashboard data.
 *
 * Provides JSON responses for summary statistics, category breakdowns
 * (for donut chart), and monthly trends (for line chart).
 * Accessible by all authenticated users via API routes.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinancialRecord;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * Get overall financial summary.
     */
    public function summary(): JsonResponse
    {
        try {
            $totalIncome = FinancialRecord::ofType('income')->sum('amount');
            $totalExpenses = FinancialRecord::ofType('expense')->sum('amount');

            return response()->json([
                'total_income' => round($totalIncome, 2),
                'total_expenses' => round($totalExpenses, 2),
                'net_balance' => round($totalIncome - $totalExpenses, 2),
                'record_count' => FinancialRecord::count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch summary data.'], 500);
        }
    }

    /**
     * Get expense totals grouped by category (for donut chart).
     */
    public function categoryTotals(): JsonResponse
    {
        try {
            $totals = FinancialRecord::ofType('expense')
                ->selectRaw('category, SUM(amount) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get()
                ->pluck('total', 'category');

            return response()->json($totals);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch category totals.'], 500);
        }
    }

    /**
     * Get monthly income vs expense for the last 6 months (for line chart).
     */
    public function monthlyTrends(): JsonResponse
    {
        try {
            $months = collect();
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $monthKey = $date->format('Y-m');
                $monthLabel = $date->format('M Y');

                $income = FinancialRecord::ofType('income')
                    ->whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->sum('amount');

                $expense = FinancialRecord::ofType('expense')
                    ->whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->sum('amount');

                $months[$monthLabel] = [
                    'income' => round($income, 2),
                    'expense' => round($expense, 2),
                ];
            }

            return response()->json($months);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch monthly trends.'], 500);
        }
    }
}
