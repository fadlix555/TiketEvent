<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #000000; opacity: 90%;">
    <div class="container">
        <i><a href="{{ route('welcome') }}" class="navbar-brand text-light"><img src="{{ asset('img/nav.png') }}" style="width: 25%"></a></i>
        <div class="navbar nav-item gap-1">
            @auth
            @if (Auth::user()->isUser())
                <a class="navbar-brand text-light" href="{{ route('history') }}"> Riwayat </a> 
                <a class="navbar-brand text-light" href="{{ route('order') }}"> Pesanan </a> 
            @endif
            <a class="btn btn-outline-light" href="{{ route('logout') }}" onclick="return confirm('Yakin Untuk logout???')"> Keluar </a> 
            @else
            <a class="btn btn-outline-light" href="{{ route('register') }}"> Daftar Akun </a>
            <a class="btn btn-light" href="{{ route('login') }}"> Masuk </a>
            @endauth
        </div>
    </div>
</nav>