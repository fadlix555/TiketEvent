<!-- welcome.blade.php -->

@extends('template.html')

@section('title', 'Home')

@section('body')
@include('template.nav')
<img src="{{ asset('img/bg.png') }}">
<div class="container" style="margin-top: 2em; margin-bottom: 3em">
    <!-- Form pencarian -->
    <form action="{{ route('cariEvent') }}" method="GET" class="mb-3">
        <div class="input-group mt-5">
            <input type="text" name="kriteria" class="form-control form-control-sm" style="max-width: 200px;" placeholder="Cari event...">
            <button type="submit" class="btn btn-dark btn-sm">Cari</button>
        </div>
    </form>
    @if (Session::has('notif'))
        <p class="alert alert-success">{{ Session::get('notif') }}</p>
    @endif
    
    <h2 class="mt-5 mb-2"> Event terbaru </h2>
    
    <div class="row mt-3">
        @if ($data->isEmpty())
            <p class="text-muted">Tidak ada event yang tersedia.</p>
        @else
            @foreach ($data as $item)
                @if ($item->status == 'active')
                    <div class="col-3 mt-4">
                        <a href="{{ route('detail', $item->id) }}" class="card card-hover text-decoration-none" style="color: black; padding: 0px">
                            <img src="{{ $item->foto }}" class="rounded-2" style="width: 100%; height: 150px; object-fit: fill">
                            <p class="card-title mt-2 ms-3" style="font-weight: bold">{{ $item->nama }}</p>
                            <h6 class="card-text ms-3 mb-3 text-muted" style="font-weight: initial">Rp {{ number_format($item->harga, 0, ',', '.') }}</h6>
                        </a>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
<img src="img/tutorial.png">
<div class="container" style="margin-top: 2em; margin-bottom: 3em">
    <h2 class="mt-3 mb-2"> Event yang telah berakhir </h2>
    
    <div class="row mt-3">
        @if ($data->isEmpty())
            <p class="text-muted">Tidak ada event yang tersedia.</p>
        @else
            @foreach ($data as $item)
                @if ($item->status == 'inactive')
                    <div class="col-3 mt-4">
                        <a href="{{ route('detail', $item->id) }}" class="card card-hover text-decoration-none" style="color: black; padding: 0px">
                            <img src="{{ $item->foto }}" class="rounded-2" style="width: 100%; height: 150px; object-fit: fill">
                            <p class="card-title mt-2 ms-3" style="font-weight: bold">{{ $item->nama }}</p>
                            <h6 class="card-text ms-3 mb-3 text-muted" style="font-weight: initial">Rp {{ number_format($item->harga, 0, ',', '.') }}</h6>
                        </a>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
@endsection
