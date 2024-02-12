@extends('template.html')

@section('title', 'Welcome')

@section('body')
@include('template.nav')
<div class="container mtp">
    @if (Session::has('notif'))
        <p class="alert alert-success">{{ Session::get('notif') }}</p>
    @endif
    <h2 class="mb-2"> Event terbaru </h2>
    
    <div class="row">
        @foreach ($data as $item)
            <a href="{{ route('detail', $item->id) }}" class="card card-hover col-sm-3 m-3 text-decoration-none" style="color: black; padding: 0px">
                    <img src="{{ $item->foto }}" class="rounded-2" style="width: 100%; height: 100%; object-fit: fill">
                    <p class="card-title mt-3 ms-3">{{ $item->nama }}</p>
                    <p class="card-title ms-3 text-muted">{{ $item->tanggal }}</p>
                    <h6 class="card-title ms-3">Rp. {{ number_format($item->harga, 0, ',', '.') }}</h6>
                    <p class="card-subtitle m-3 text-muted">{{ $item->category->nama }}</p>
            </a>
        @endforeach
    </div>
</div>
@endsection
