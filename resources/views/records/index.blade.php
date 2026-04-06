@extends('layouts.app')

@section('title', 'Financial Records')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Financial Records</h1>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('records.create') }}" class="btn btn-primary" id="btn-add-record">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Record
            </a>
        @endif
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('records.index') }}" class="filter-bar" id="filter-form">
        <div class="filter-group">
            <label for="filter-type">Type</label>
            <select name="type" id="filter-type" class="form-control">
                <option value="">All Types</option>
                <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="filter-category">Category</label>
            <select name="category" id="filter-category" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label for="filter-date-from">From</label>
            <input type="date" name="date_from" id="filter-date-from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="filter-group">
            <label for="filter-date-to">To</label>
            <input type="date" name="date_to" id="filter-date-to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <button type="submit" class="btn btn-primary btn-sm" id="btn-filter">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            Filter
        </button>
        @if(request()->hasAny(['type', 'category', 'date_from', 'date_to']))
            <a href="{{ route('records.index') }}" class="btn btn-secondary btn-sm" id="btn-clear-filter">Clear</a>
        @endif
    </form>

    {{-- Records Table --}}
    <div class="table-card">
        <table class="data-table" id="records-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Notes</th>
                    @if(auth()->user()->isAdmin())
                        <th style="text-align: right;">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        <td>{{ $record->date->format('M d, Y') }}</td>
                        <td><span class="category-tag">{{ $record->category }}</span></td>
                        <td><span class="badge badge-{{ $record->type }}">{{ ucfirst($record->type) }}</span></td>
                        <td class="amount-{{ $record->type }}">{{ $record->formatted_amount }}</td>
                        <td>{{ Str::limit($record->notes, 40) ?? '—' }}</td>
                        @if(auth()->user()->isAdmin())
                            <td style="text-align: right;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="{{ route('records.edit', $record) }}" class="btn-icon" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('records.destroy', $record) }}" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <h4>No records found</h4>
                                <p>Try adjusting your filters or add a new record.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($records->hasPages())
            <div class="pagination-wrap">
                {{-- Previous --}}
                @if($records->onFirstPage())
                    <span class="page-link disabled">‹</span>
                @else
                    <a href="{{ $records->previousPageUrl() }}" class="page-link">‹</a>
                @endif

                @foreach ($records->getUrlRange(1, $records->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-link {{ $records->currentPage() == $page ? 'active' : '' }}">{{ $page }}</a>
                @endforeach

                {{-- Next --}}
                @if($records->hasMorePages())
                    <a href="{{ $records->nextPageUrl() }}" class="page-link">›</a>
                @else
                    <span class="page-link disabled">›</span>
                @endif
            </div>
        @endif
    </div>
@endsection
