<nav class="navbar navbar-expand-lg" style="background-color: rgb(73, 139, 198)">
    <div class="container">
        <a class="navbar-brand text-light" href="{{ route('welcome') }}"> Home </a> 
        @auth
        <div class="navbar nav-item gap-1">
            @if (Auth::user()->isUser())
                <a class="navbar-brand text-light" href="{{ route('order') }}"> Order </a> 
            @endif
            @if (Auth::user()->isKasir())
                <a href="{{ route('orders') }}" class="navbar-brand text-light"> Acceptment Order </a>
            @endif
            @if (Auth::user()->isOwner())
                <a href="{{ route('riwayat') }}" class="navbar-brand text-light">Riwayat</a>
            @endif
            <a class="navbar-brand text-light" href="{{ route('logout') }}"> Logout </a> 
            @else
            <a class="navbar-brand text-light" href="{{ route('login') }}"> Please, Login first </a>
        </div>
        @endauth
    </div>
</nav>