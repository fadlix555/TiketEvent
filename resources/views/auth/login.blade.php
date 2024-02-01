@extends('template.html')

@section('title', 'Login')

@section('container')   
<div class="container mt-5">
    @if (Session::has('error'))
        <p class="alert alert-danger">{{ Session::get('error') }}</p>
    @endif
    @if (Session::has('notif'))
        <p class="alert alert-success">{{ Session::get('notif') }}</p>
    @endif
    <h3 class="text-center" style="margin-top: 5em; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif"> TIVENT BARAJA </h3>
    <div class="card col-md-4 mx-auto p-3 text-white" style="background-color: rgb(73, 139, 198);">
        <form action="{{ route('postlogin') }}" method="POST" enctype="multipart/form-data" class="form-group">
            @csrf
            <h3 class="text-center">Login</h3>
            
            <label for="nama" class="mt-2">Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" required>
            
            <label for="password" class="mt-2">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
            
            <div class="d-flex mt-3">
                <button type="submit" class="btn btn-outline-light me-2">Login</button>
                <a href="{{ route('welcome') }}" class="btn btn-light">Kembali</a>
                <a href="{{ route('register') }}" class="btn btn-light ms-auto">Register</a>
            </div>
        </form>
    </div>
</div>
@endsection
