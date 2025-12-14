<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','ArtSpace')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #0e0e0e;
            color: #e5e7eb;
        }

        .navbar {
            background-color: #111827;
            border-bottom: 1px solid #1f2933;
        }

        .sidebar {
            background-color: #111827;
            min-height: 100vh;
            border-right: 1px solid #1f2933;
        }

        .card {
            background-color: #18181b;
            border: 1px solid #27272a;
        }

        .text-muted {
            color: #9ca3af !important;
        }

        .btn-primary {
            background-color: #6366f1;
            border: none;
        }

        .btn-outline-light {
            border-color: #374151;
            color: #e5e7eb;
        }

        .btn-outline-light:hover {
            background-color: #1f2937;
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

</body>
</html>
