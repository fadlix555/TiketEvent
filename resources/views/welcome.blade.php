@extends('template.html')

@section('title', 'Welcome')

@section('container')
@include('template.nav')
<div class="container mt-5">
    @if (Session::has('notif'))
        <p class="alert alert-success">{{ Session::get('notif') }}</p>
    @endif
    <div class="row">
        @foreach ($data as $item)
        <div class="card col-md-3 mb-4 m-3">
            <img src="{{ $item->foto }}" class="card-img-top" style="height: 300px; width: 300px; object-fit: cover">
            <div class="card-body">
                <h5 class="card-title">{{ $item->nama }}</h5>
                <p class="card-subtitle mb-2 text-muted">{{ $item->category->nama }}</p>
                <a href="{{ route('detail', $item->id) }}" class="btn btn-primary">Detail</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
