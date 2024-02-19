@extends('template.html')

@section('title', 'Detail Event')

@section('body')
@include('template.nav')
<div class="container mtp">
    @if (Session::has('notif'))
        <p class="alert alert-danger">{{ Session::get('notif') }}</p>
    @endif
    <form action="{{ route('postorder', $Event->id) }}" method="POST">
        @csrf
        <div class="row align-items-center">
            <div class="row h-100 align-items-center">
                <div class="card col-sm-3 mx-auto mb-4">
                    <img src="{{ asset($Event->foto)}}" style="width: 100%; height: 100%; object-fit: fill">
                </div>
            </div>
            <hr>
            <div class="col-md-12">
                <div class="card p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="text-center mb-4">{{ $Event->nama }}</h2>
                            <div class="card mb-4">
                                <iframe src="{{ $Event->map }}" width="100%" height="300" style="border:0;" loading="lazy"></iframe>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="card col-2">
                                    <img src="{{ asset('img/location.png') }}" height="75px" class="p-2">
                                    <p class="card-text text-center">Lokasi</p>
                                </div>
                                <div class="card col-4" height="75px">
                                    <h6 class="my-auto">{{ $Event->lokasi }}</h6>
                                    <hr>
                                    <h6 class="my-auto"><strong>Kategori: </strong>{{ $Event->category->nama }}</h6>
                                </div>
                                <div class="card col-sm-2">
                                    <img src="{{ asset('img/calendar.png') }}" height="75px" class="p-2">
                                    <p class="card-text text-center">Tanggal & Waktu</p>
                                </div>
                                <div class="card col-4" height="75px">
                                    <h6 class="my-auto"><strong>Tanggal: </strong>{{ $Event->tanggal }} </h6>
                                    <hr>
                                    <h6 class="my-auto"><strong>Waktu: </strong> {{ $Event->waktu }}</h6>
                                </div>
                            </div>
                            @if ($Event->status == 'inactive')
                                <div class="card mt-5 p-4">
                                    <hr>
                                    <h5 class="text-center">Event sudah selesai</h5>
                                    <hr>
                                </div>
                            @else
                            <div class="card p-4">
                                <h4 class="text-center mb-4">Pesan Tiket</h4>
                                <h6 class="card-text">Rp. {{ number_format($Event->harga, 0, ',', '.') }}</h6>
                                <h6 class="card-text">Sisa Tiket: {{ number_format($Event->stok, 0, ',', '.') }}</h6>
                                <label for="banyak" class="form-label">Total Pesanan:</label>
                                <input type="number" name="banyak" class="form-control" required value="1" min="1">
                                <hr>
                                @if (auth()->check())
                                    <button type="submit" class="btn btn-primary mb-2">Pesan Sekarang</button>
                                @else
                                    <button type="submit" class="btn btn-primary mb-2">Masuk</button>
                                @endif
                                <a href="/" class="btn btn-dark mb-2">Kembali</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection
