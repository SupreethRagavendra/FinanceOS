<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Access Denied | FinanceOS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="error-page">
        <div class="error-content">
            <div class="error-code">403</div>
            <h1 class="error-title">Access Denied</h1>
            <p class="error-message">
                You don't have permission to access this page.
                @if(isset($userRole))
                    Your current role is <strong>{{ ucfirst($userRole) }}</strong>.
                @endif
                @if(isset($requiredRoles))
                    This page requires one of the following roles: <strong>{{ implode(', ', array_map('ucfirst', $requiredRoles)) }}</strong>.
                @endif
            </p>
            <div class="btn-group" style="justify-content: center;">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Back to Dashboard
                </a>
                <a href="{{ route('login') }}" class="btn btn-secondary">Sign In as Different User</a>
            </div>
        </div>
    </div>
</body>
</html>
