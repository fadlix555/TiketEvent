@extends('template.html')

@section('title', 'Register')

@section('container')   
<div class="container mt-5">
    @if ($errors->has('password'))
        <div class="alert alert-danger">
            {{ $errors->first('password') }}
        </div>
    @endif
    <h3 class="text-center" style="margin-top: 5em; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif"> TIVENT BARAJA </h3>
    <div class="card col-md-4 mx-auto p-3 text-white" style="background-color: rgb(73, 139, 198);">
        <form action="{{ route('postregister') }}" method="POST" enctype="multipart/form-data" class="form-group">
            @csrf
            <h3 class="text-center">Register</h3>
            
            <label for="nama" class="mt-2">Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" required>
            
            <label for="email" class="mt-2">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
            
            <label for="password" class="mt-2">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>

            <label for="password_confirmation" class="mt-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
            
            <button type="submit" class="btn btn-outline-light mt-3"> Register </button>
            <a href="/" class="btn btn-light mt-3">Kembali</a>
        </form>
    </div>
</div>
@endsection