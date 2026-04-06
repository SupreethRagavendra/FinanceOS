@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Stat Cards --}}
    <div class="stat-cards">
        <div class="stat-card green" id="card-income">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><polyline points="17 6 12 1 7 6"/></svg>
            </div>
            <div class="stat-label">Total Income</div>
            <div class="stat-value" id="stat-income">₹{{ number_format($totalIncome, 2) }}</div>
        </div>
        <div class="stat-card red" id="card-expenses">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="23" x2="12" y2="1"/><polyline points="7 18 12 23 17 18"/></svg>
            </div>
            <div class="stat-label">Total Expenses</div>
            <div class="stat-value" id="stat-expenses">₹{{ number_format($totalExpenses, 2) }}</div>
        </div>
        <div class="stat-card blue" id="card-balance">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div class="stat-label">Net Balance</div>
            <div class="stat-value" id="stat-balance">₹{{ number_format($netBalance, 2) }}</div>
        </div>
        <div class="stat-card purple" id="card-records">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div class="stat-label">Total Records</div>
            <div class="stat-value" id="stat-records">{{ $recordCount }}</div>
        </div>
    </div>



    {{-- Recent Transactions --}}
    <div class="table-card" id="recent-transactions">
        <div class="table-card-header">
            <h3>Recent Transactions</h3>
            <a href="{{ route('records.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentRecords as $record)
                    <tr>
                        <td>{{ $record->date->format('M d, Y') }}</td>
                        <td><span class="category-tag">{{ $record->category }}</span></td>
                        <td><span class="badge badge-{{ $record->type }}">{{ ucfirst($record->type) }}</span></td>
                        <td class="amount-{{ $record->type }}">{{ $record->formatted_amount }}</td>
                        <td>{{ $record->notes ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 32px;">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection


