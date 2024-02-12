<nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgb(73, 139, 198)">
    <div class="container">
        <a href="#" class="navbar-brand text-light" style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> TIVENT </a>
        <div class="navbar nav-item gap-1">
            @if (Auth::user()->isAdmin())
                <a href="{{ route('admin') }}" class="navbar-brand text-light"> CRUD </a>
                <a href="{{ route('log') }}" class="navbar-brand text-light">Log</a>
                <a href="{{ route('orders') }}" class="navbar-brand text-light">Accept Orders</a>
                <a href="{{ route('riwayat') }}" class="navbar-brand text-light">Riwayat</a>
            @endif
            @if (Auth::user()->isKasir())
                <a href="{{ route('orders') }}" class="navbar-brand text-light">Accept Orders</a>
                <a href="{{ route('riwayat') }}" class="navbar-brand text-light">Riwayat</a>
            @endif
            @if (Auth::user()->isOwner())
                <a href="{{ route('log') }}" class="navbar-brand text-light">Log</a>
                <a href="{{ route('riwayat') }}" class="navbar-brand text-light">Riwayat</a>
            @endif
            <a href="{{ route('logout') }}" onclick="return confirm('Yakin Untuk logout???')" class="btn custom-btn text-light">logout</a>
        </div>
    </div>
</nav>
