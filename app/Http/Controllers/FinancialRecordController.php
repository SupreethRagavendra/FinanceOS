<?php

/**
 * FinancialRecordController - CRUD operations for financial records.
 *
 * Handles listing with filters/pagination, creating, editing,
 * and soft-deleting financial records. Create/edit/delete actions
 * are restricted to admin users via RoleMiddleware.
 */

namespace App\Http\Controllers;

use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialRecordController extends Controller
{
    /**
     * List all financial records with optional filters and pagination.
     */
    public function index(Request $request)
    {
        $query = FinancialRecord::with('user')->latest('date');

        // Apply filters
        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        if ($request->filled('category')) {
            $query->ofCategory($request->category);
        }

        if ($request->filled('date_from') || $request->filled('date_to')) {
            $query->dateBetween($request->date_from, $request->date_to);
        }

        $records = $query->paginate(15)->withQueryString();

        // Get unique categories for filter dropdown
        $categories = FinancialRecord::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('records.index', compact('records', 'categories'));
    }

    /**
     * Show form to create a new financial record (admin only).
     */
    public function create()
    {
        return view('records.create');
    }

    /**
     * Store a new financial record (admin only).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $validated['user_id'] = Auth::id();
            FinancialRecord::create($validated);

            return redirect()->route('records.index')
                ->with('success', 'Financial record created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create record. Please try again.');
        }
    }

    /**
     * Show form to edit a financial record (admin only).
     */
    public function edit(FinancialRecord $record)
    {
        return view('records.edit', compact('record'));
    }

    /**
     * Update a financial record (admin only).
     */
    public function update(Request $request, FinancialRecord $record)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $record->update($validated);

            return redirect()->route('records.index')
                ->with('success', 'Financial record updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update record. Please try again.');
        }
    }

    /**
     * Soft delete a financial record (admin only).
     */
    public function destroy(FinancialRecord $record)
    {
        try {
            $record->delete();

            return redirect()->route('records.index')
                ->with('success', 'Financial record deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete record. Please try again.');
        }
    }
}
