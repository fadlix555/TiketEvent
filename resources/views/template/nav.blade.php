<nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgb(73, 139, 198)">
    <div class="container">
        <a href="{{ route('welcome') }}" class="navbar-brand text-light" style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> TIVENT </a>
        <div class="navbar nav-item gap-1">
            @auth
            @if (Auth::user()->isUser())
                <a class="navbar-brand text-light" href="{{ route('history') }}"> History </a> 
                <a class="navbar-brand text-light" href="{{ route('order') }}"> Order </a> 
            @endif
            <a class="btn custom-btn text-light" href="{{ route('logout') }}" onclick="return confirm('Yakin Untuk logout???')"> Logout </a> 
            @else
            <a class="btn custom-btn text-light" href="{{ route('register') }}"> Daftar Akun </a>
            <a class="btn btn-primary text-light" href="{{ route('login') }}"> Masuk </a>
            @endauth
        </div>
    </div>
</nav>