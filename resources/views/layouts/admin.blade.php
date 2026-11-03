<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Jurnal Ilmiah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-admin {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-admin .navbar-brand {
            color: white;
            font-weight: 600;
            font-size: 1.3rem;
        }
        .navbar-admin .navbar-brand:hover {
            color: #e0e0e0;
        }
        .navbar-admin .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .navbar-admin .nav-link:hover,
        .navbar-admin .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .navbar-admin .navbar-toggler {
            border-color: white;
            padding: 8px 12px;
        }
        .navbar-admin .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-admin .navbar-text {
            color: white;
        }
        .navbar-admin .dropdown-menu {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .navbar-admin .navbar-collapse {
                background-color: rgba(30, 58, 138, 0.98);
                padding: 15px;
                border-radius: 10px;
                margin-top: 10px;
            }
            .navbar-admin .nav-link {
                margin: 5px 0;
            }
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.85rem;
            }
            .card-header h5 {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-admin .navbar-brand {
                font-size: 1.1rem;
            }
            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-admin">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-journal-text"></i> Jurnal Ilmiah - Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdminContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarAdminContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <i class="bi bi-folder"></i> Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}" href="{{ route('admin.articles.index') }}">
                            <i class="bi bi-file-text"></i> Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}" href="{{ route('admin.submissions.index') }}">
                            <i class="bi bi-inbox"></i> Submission
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.index') }}">
                            <i class="bi bi-globe"></i> Lihat Website
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container-fluid px-4 py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
