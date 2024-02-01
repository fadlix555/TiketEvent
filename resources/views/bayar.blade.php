@extends('template.html')

@section('title', 'Bayar')

@section('container')
@include('template.nav')

<div class="container mt-5">
    <div class="card col-6 p-3 mx-auto">
        <form action="{{ route('postbayar', $detailorder->id) }}" method="POST" class="form-group" enctype="multipart/form-data">
            @csrf
            <h3 class="text-center mb-4">{{ $event->nama }}</h3>

            <div class="text-center mb-3">
                <img src="{{ asset($event->foto) }}" class="w-25">
            </div>

            <p class="text-center">Transfer ke Bank PDI No: 7946939369</p>
            <p class="text-center">Pesan Tiket: {{ $detailorder->qty }}</p>
            <p class="text-center">Harga Total: {{ $detailorder->pricetotal }}</p>

            <div class="mb-3">
                <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Kirim</button>
        </form>
    </div>
</div>
@endsection
