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
        box-shadow: 0px 2px 2px 0px;
    }
    

    .border-bottom {
        border: none;
        border-bottom: 1px solid #ced4da; /* Bootstrap gray color for the underline */
        border-radius: 0;
    }
</style>
<body>
    <div class="container mt-2">
        @if ($errors->has('password'))
            <div class="alert alert-danger">
                {{ $errors->first('password') }}
            </div>
        @endif
        <h3 class="text-center mb-5" style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;"> TIVENT </h3>
        
        <form action="{{ route('postregister') }}" method="POST" class="col-md-4 mx-auto" style="margin-top: 5em;">
            @csrf
            <h3 class="text-center">Register</h3>
                
                <h6 class="text-center mb-2 text-muted">Sudah punya akun? <a href="{{ route('login') }}" style="text-decoration: none;"> Login </a> </h6>
            <div class="card p-4 col-12 mx-auto">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control border-bottom" placeholder="Masukkan Nama" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control border-bottom" placeholder="Masukkan Email" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control border-bottom" placeholder="Masukkan Password" required>
                </div>
    
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control border-bottom" placeholder="Konfirmasi Password" required>
                </div>
                
                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-primary text-light">Register</button>
                </div>
            </div>
        </form>
    </div>    
</body>
</html>

