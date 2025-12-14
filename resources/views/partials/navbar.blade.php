<nav class="navbar navbar-dark px-4">
    <a class="navbar-brand fw-bold" href="{{ route('landing') }}">ArtSpace</a>

    <div class="d-flex align-items-center gap-3">
        @auth
            <span class="text-muted small">
                {{ auth()->user()->name }} ({{ auth()->user()->role }})
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-light">Logout</button>
            </form>
        @else
            <a href="{{ route('login.page') }}" class="btn btn-sm btn-outline-light">Login</a>
        @endauth
    </div>
</nav>
