<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArtSpace')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0e0e0e 0%, #1a1a2e 100%);
            color: #e5e7eb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* Navbar Styling */
        .navbar {
            background-color: rgba(17, 24, 39, 0.8);
            border-bottom: 1px solid #27272a;
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Sidebar Styling */
        .sidebar {
            background: rgba(17, 24, 39, 0.6);
            min-height: 100vh;
            border-right: 1px solid #27272a;
            color: #ffffff;
            padding: 2rem 0;
        }

        .sidebar-brand {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid #27272a;
            margin-bottom: 1rem;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .sidebar a {
            color: #d1d5db !important;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            display: block;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover {
            color: #ffffff !important;
            background-color: rgba(99, 102, 241, 0.1);
            border-left-color: #6366f1;
        }

        .sidebar a.active {
            color: #6366f1 !important;
            background-color: rgba(99, 102, 241, 0.1);
            border-left-color: #6366f1;
            font-weight: 600;
        }

        /* Main Content */
        main {
            padding: 2rem !important;
        }

        /* Card Styling */
        .card {
            background: rgba(24, 24, 27, 0.8);
            border: 1px solid #27272a;
            border-radius: 12px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .card:hover {
            border-color: #6366f1;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.1);
        }

        .card-header {
            background-color: rgba(17, 24, 39, 0.5);
            border-bottom: 1px solid #27272a;
        }

        /* Text Colors */
        .text-muted {
            color: #d1d5db !important;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #f3f4f6 !important;
        }

        .card-title {
            color: #f3f4f6 !important;
            font-weight: 600 !important;
        }

        .card-body {
            color: #e5e7eb;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #6d28d9);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-outline-primary {
            color: #6366f1;
            border-color: #6366f1;
        }

        .btn-outline-primary:hover {
            background-color: rgba(99, 102, 241, 0.1);
            color: #a5b4fc;
        }

        .btn-outline-secondary {
            border-color: #6b7280;
            color: #d1d5db;
        }

        .btn-outline-secondary:hover {
            background-color: rgba(107, 114, 128, 0.1);
            border-color: #9ca3af;
        }

        .btn-outline-danger {
            border-color: #ef4444;
            color: #f87171;
        }

        .btn-outline-danger:hover {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: #dc2626;
        }

        .btn-success {
            background-color: #10b981;
            border: none;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        /* Card Hover Effect */
        .card-hover {
            cursor: pointer;
        }

        .card-hover:hover {
            border-color: #6366f1;
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.1);
        }

        /* Stats */
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(99, 102, 241, 0.15);
            color: #6366f1;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .icon-box:hover {
            background: rgba(99, 102, 241, 0.25);
            transform: scale(1.1);
        }

        /* Table Styling */
        .table {
            color: #e5e7eb;
        }

        .table thead {
            background-color: rgba(17, 24, 39, 0.8);
            border-bottom: 2px solid #27272a;
        }

        .table th {
            color: #a5b4fc;
            font-weight: 600;
            border: none;
        }

        .table td {
            border-color: #27272a;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.05);
        }

        /* Form Controls */
        .form-control, .form-select {
            background-color: #18181b;
            border: 1px solid #27272a;
            color: #e5e7eb;
        }

        .form-control:focus, .form-select:focus {
            background-color: #1a1a1d;
            border-color: #6366f1;
            color: #e5e7eb;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-control option {
            background-color: #18181b;
            color: #e5e7eb;
        }

        .form-label {
            color: #e5e7eb !important;
        }

        small {
            color: #d1d5db !important;
        }

        p {
            color: #e5e7eb !important;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            padding: 0.5rem 0.75rem;
        }

        .badge.bg-success {
            background-color: rgba(16, 185, 129, 0.2) !important;
            color: #6ee7b7;
        }

        .badge.bg-warning {
            background-color: rgba(245, 158, 11, 0.2) !important;
            color: #fcd34d;
        }

        .badge.bg-danger {
            background-color: rgba(239, 68, 68, 0.2) !important;
            color: #fca5a5;
        }

        .badge.bg-info {
            background-color: rgba(59, 130, 246, 0.2) !important;
            color: #93c5fd;
        }

        /* Alert Styling */
        .alert {
            border: 1px solid;
            border-radius: 8px;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
            color: #86efac;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.3);
            color: #fde047;
        }

        .alert-info {
            background-color: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
            color: #bfdbfe;
        }

        /* Pagination */
        .pagination {
            gap: 0.5rem;
        }

        .page-link {
            background-color: transparent;
            border: 1px solid #27272a;
            color: #6366f1;
        }

        .page-link:hover {
            background-color: rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
            color: #a5b4fc;
        }

        .page-item.active .page-link {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                width: 250px;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .sidebar.show {
                left: 0;
            }

            main {
                padding: 1rem !important;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <div class="container-fluid">
        <div class="row">
            @auth
                @include('partials.sidebar')
            @endauth

            <main class="col p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
