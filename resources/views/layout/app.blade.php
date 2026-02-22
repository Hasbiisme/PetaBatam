<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Menggunakan Tailwind CSS untuk form di create/edit --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { min-width: 220px; max-width: 220px; background-color: #6f42c1; color: #fff; min-height: 100vh; }
        .sidebar h4 { margin: 0; font-size: 1.8rem; font-weight: 600; text-align: center; margin-top: 2rem; margin-bottom: 3rem; }
        .sidebar a { color: #e0d7f5; text-decoration: none; padding: 10px 20px; display: flex; align-items: center; border-radius: 8px; margin-bottom: 8px; transition: all 0.3s; }
        .sidebar a:hover, .sidebar .nav-link.active { color: #fff; background-color: rgba(255,255,255,0.2); }
        .sidebar i { margin-right: 10px; font-size: 1.2rem; }
        .main-content { flex-grow: 1; }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar d-flex flex-column p-3">
        <h4>Admin</h4>
        <hr class="border-top border-white my-2 w-100">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('admin.places.*', 'dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> <span class="ms-2">Dashboard Utama</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('admin.small-destinations.index') }}" class="nav-link {{ request()->routeIs('admin.small-destinations.*') ? 'active' : '' }}">
                    <i class="bi bi-pin-map-fill"></i> <span class="ms-2">Rekomendasi Destinasi</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>