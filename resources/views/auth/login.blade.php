<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<style>
    .card{
        border-top: #ced4da;
        box-shadow: 0px 2px 3px 0px;
    }

    .border-bottom {
        border: none;
        border-bottom: 1px solid #ced4da; /* Bootstrap gray color for the underline */
        border-radius: 0;
    }

</style>
<body>
    <div class="container mt-2">
        @if (Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
        @endif
        @if (Session::has('notif'))
            <p class="alert alert-success">{{ Session::get('notif') }}</p>
        @endif
        <h3 class="text-center mb-5" style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;"> TIVENT </h3>
        
        <form action="{{ route('postlogin') }}" method="POST" class="col-md-4 mx-auto" style=" margin-top: 7em">
            @csrf
            <h4 class="text-center mb-2">Login ke akun mu</h4>
            <h6 class="text-center mb-2 text-muted">Tidak punya akun Tivent? <a href="{{ route('register') }}" style="text-decoration: none;"> Daftar </a></h6>
            <div class="card p-3 col-8 mx-auto">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control border-bottom" placeholder="Masukkan Nama" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control border-bottom" placeholder="Masukkan Password" required>
                </div>
                
                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
        </form>
    </div>
    
</body>
</html>
