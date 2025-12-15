<div class="col-md-2 sidebar p-3">

    @if (auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="d-block mb-2 text-light">Dashboard</a>
        <a href="{{ route('admin.users.index') }}" class="d-block mb-2 text-light">Users</a>
        <a href="{{ route('admin.orders.index') }}" class="d-block mb-2 text-light">Orders</a>
    @endif

    @if (auth()->user()->role === 'artist')
        <a href="{{ route('artist.dashboard') }}" class="d-block mb-2 text-light">Dashboard</a>
        <a href="{{ route('artworks.index') }}" class="d-block mb-2 text-light">Artworks</a>
        <a href="{{ route('services.index') }}" class="d-block mb-2 text-light">Services</a>
        <a href="{{ route('orders.index') }}" class="d-block mb-2 text-light">Orders</a>
        <a href="{{ route('invoices.index') }}" class="d-block mb-2 text-light">Invoices</a>
    @endif

    @if (auth()->user()->role === 'buyer' || auth()->user()->role === 'client')
        <a href="{{ route('buyer.dashboard') }}" class="d-block mb-2 text-light">Dashboard</a>
        <a href="{{ route('services.index') }}" class="d-block mb-2 text-light">Browse Services</a>
        <a href="{{ route('orders.index') }}" class="d-block mb-2 text-light">My Orders</a>
        <a href="{{ route('invoices.index') }}" class="d-block mb-2 text-light">Invoices</a>
    @endif

    <!-- Profile Link -->
    <hr class="border-secondary my-3">
    <a href="{{ route('profile.edit') }}" class="d-block mb-2 text-light">
        <i class="fas fa-user-circle me-1"></i> Profile
    </a>
</div>
