<nav class="navbar navbar-expand-lg" style="background-color: rgb(73, 139, 198)">
    <div class="container">
        <a href="{{ route('admin') }}" class="navbar-brand text-light">Home</a>
        <div class="navbar nav-item gap-1">
            <a href="{{ route('riwayat') }}" class="navbar-brand text-light">Riwayat</a>
            <a href="{{ route('orders') }}" class="navbar-brand text-light">Orders</a>
            <a href="{{ route('logout') }}" class="navbar-brand text-light">logout</a>
        </div>
    </div>
</nav>
