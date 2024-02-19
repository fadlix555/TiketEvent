<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #000000; opacity: 90%;">
    <div class="container">
        <i><a href="#" class="navbar-brand text-light"><img src="{{ asset('img/nav.png') }}" style="width: 25%"></a></i>
        <div class="navbar nav-item gap-1">
            @if (Auth::user()->isAdmin())
                <a href="{{ route('admin') }}" class="navbar-brand text-light"> Admin </a>
                <a href="{{ route('orders') }}" class="navbar-brand text-light"> Pesanan </a>
                <a href="{{ route('riwayat') }}" class="navbar-brand text-light">Riwayat</a>
            @endif
            @if (Auth::user()->isKasir())
                <a href="{{ route('orders') }}" class="navbar-brand text-light"> Pesanan </a>
                <a href="{{ route('riwayat') }}" class="navbar-brand text-light">Riwayat</a>
            @endif
            @if (Auth::user()->isOwner())
                <a href="{{ route('admin') }}" class="navbar-brand text-light"> Admin </a>
                <a href="{{ route('log') }}" class="navbar-brand text-light"> Log </a>
                <a href="{{ route('riwayat') }}" class="navbar-brand text-light"> Riwayat </a>
            @endif
            <a href="{{ route('logout') }}" onclick="return confirm('Yakin Untuk logout???')" class="btn btn-outline-light"> Keluar </a>
        </div>
    </div>
</nav>
