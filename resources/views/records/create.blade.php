@extends('layouts.app')

@section('title', 'Add Record')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Add Financial Record</h1>
    </div>

    <div class="form-card">
        <h2>New Record</h2>
        <form method="POST" action="{{ route('records.store') }}" id="record-create-form">
            @csrf

            <div class="form-group">
                <label for="amount">Amount (₹)</label>
                <input type="number" step="0.01" min="0.01" id="amount" name="amount" class="form-control" placeholder="0.00" value="{{ old('amount') }}" required>
                @error('amount')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="">Select type</option>
                    <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Income</option>
                    <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                </select>
                @error('type')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" class="form-control" placeholder="e.g. Salary, Rent, Food" value="{{ old('category') }}" list="category-list" required>
                <datalist id="category-list">
                    <option value="Salary">
                    <option value="Freelance">
                    <option value="Bonus">
                    <option value="Investment">
                    <option value="Rent">
                    <option value="Food">
                    <option value="Transport">
                    <option value="Utilities">
                    <option value="Shopping">
                    <option value="Healthcare">
                    <option value="Education">
                    <option value="Entertainment">
                </datalist>
                @error('category')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                @error('date')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Notes (optional)</label>
                <textarea id="notes" name="notes" class="form-control" placeholder="Add any notes about this record...">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="btn-submit-record">Save Record</button>
                <a href="{{ route('records.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
