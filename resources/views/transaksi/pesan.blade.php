@extends('template.html')

@section('title', 'Order')

@section('body')
@include('template.nav')

<div class="container mtp">
    <h2 class="text-center"> Pesanan </h2>
    @if (Session::has('notif'))
        <div class="alert alert-success">{{ Session::get('notif') }}</div>
    @endif
    @foreach ($detailorder as $do)
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset($do->Event->foto) }}" class="img-fluid">
                </div>
                <div class="col-md-9">
                    <p><strong>Event:</strong> {{ $do->Event->nama }}</p>
                    <p><strong>Tanggal:</strong> {{ $do->Event->tanggal }}</p>
                    <p><strong>Waktu:</strong> {{ $do->Event->waktu }}</p>
                    <p><strong>Tempat:</strong> {{ $do->Event->lokasi }}</p>
                    <p><strong>Jumlah Tiket:</strong> {{ $do->qty }}</p>
                    <p><strong>Total Harga:</strong> Rp.{{ number_format($do->pricetotal, 0, '.', '.') }}</p>
                    <p><strong>Status Pembayaran:</strong> {{ $do->status_pembayaran }}</p>

                    
                        <a href="{{ route('bayar', $do->id) }}" class="btn btn-primary">Bayar</a>
                        <a href="{{ route('batalkanpesanan', $do->id) }}" class="btn btn-danger" onclick="return confirm('Yakin untuk membatalkan???')">Batalkan Pesanan</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
