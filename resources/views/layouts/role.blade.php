<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 15px; }
    </style>
</head>
<body>

    <nav>
        @auth
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Logout
            </a>

            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>
        @endauth
    </nav>

    <h1>{{ $title }}</h1>

    <div>
        {{ $slot }}
    </div>

</body>
</html>
