@extends('template.html')

@section('title', 'Detail Event')

@include('template.nav')
@section('body')
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
                            <div class="card p-4">
                                <h4 class="text-center mb-4">Pesan Tiket</h4>
                                <p class="card-text"><strong>Lokasi:</strong> {{ $Event->lokasi }}</p>
                                <p class="card-text"><strong>Tanggal:</strong> {{ $Event->tanggal }}</p>
                                <p class="card-text"><strong>Waktu:</strong> {{ $Event->waktu }}</p>
                                <h6 class="card-text">Rp. {{ number_format($Event->harga, 0, ',', '.') }}</h6>
                                <h6 class="card-text">Sisa Tiket: {{ number_format($Event->stok, 0, ',', '.') }}</h6>
                                <label for="banyak" class="form-label">Total Pesanan:</label>
                                <input type="number" name="banyak" class="form-control" required value="1" min="1">
                                <hr>
                                <button type="submit" class="btn btn-primary mb-2">Pesan Sekarang</button>
                                <a href="/" class="btn btn-dark mb-2">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection
