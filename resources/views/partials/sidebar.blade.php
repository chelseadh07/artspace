<div class="col-md-2 sidebar p-3">
    <h5 class="text-light mb-4">ArtSpace</h5>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="d-block mb-2 text-light">Dashboard</a>
        <a href="{{ route('admin.users.index') }}" class="d-block mb-2 text-light">Users</a>
        <a href="{{ route('admin.orders.index') }}" class="d-block mb-2 text-light">Orders</a>
    @endif

    @if(auth()->user()->role === 'artist')
        <a href="{{ route('artist.dashboard') }}" class="d-block mb-2 text-light">Dashboard</a>
        <a href="{{ route('artworks.index') }}" class="d-block mb-2 text-light">Artworks</a>
        <a href="{{ route('services.index') }}" class="d-block mb-2 text-light">Services</a>
        <a href="{{ route('orders.index') }}" class="d-block mb-2 text-light">Orders</a>
    @endif

    @if(auth()->user()->role === 'buyer')
        <a href="{{ route('buyer.dashboard') }}" class="d-block mb-2 text-light">Dashboard</a>
        <a href="{{ route('services.index') }}" class="d-block mb-2 text-light">Browse Services</a>
        <a href="{{ route('orders.index') }}" class="d-block mb-2 text-light">My Orders</a>
    @endif
</div>
