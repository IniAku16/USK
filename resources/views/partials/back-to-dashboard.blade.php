@php
    $role = session('role');
    $dashboardRoute = match ($role) {
        'administrator' => '/admin/dashboard',
        'owner' => '/owner/dashboard',
        'waiter' => '/waiter/dashboard',
        'kasir' => '/kasir/dashboard',
        default => '/login',
    };
@endphp

<a href="{{ $dashboardRoute }}" class="btn btn-outline-secondary mb-3">
    ← Kembali ke Dashboard
    </a>


