<?php

/**
 * DashboardController - Renders the main dashboard page.
 *
 * Displays summary statistics (total income, expenses, net balance),
 * recent transactions, and provides data for Chart.js visualizations.
 * Accessible by all authenticated, active users.
 */

namespace App\Http\Controllers;

use App\Models\FinancialRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with summary cards and recent records.
     */
    public function index()
    {
        $totalIncome = FinancialRecord::ofType('income')->sum('amount');
        $totalExpenses = FinancialRecord::ofType('expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;
        $recordCount = FinancialRecord::count();

        $recentRecords = FinancialRecord::with('user')
            ->latest('date')
            ->take(10)
            ->get();

        return view('dashboard.index', compact(
            'totalIncome',
            'totalExpenses',
            'netBalance',
            'recordCount',
            'recentRecords'
        ));
    }
}
