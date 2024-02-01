@extends('template.html')

@section('title', 'Order')

@section('container')
@include('template.nav')

<div class="container mt-5">
    @foreach ($detailorder as $do)
    <div class="card mt-3">
        <div class="card-header">
            <h3>Detail Pesanan</h3>
        </div>
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

                    @if ($do->bukti_pembayaran)
                        <p>Anda sudah membayar. Menunggu konfirmasi</p>
                    @elseif ($do->status_pembayaran == 'rejected')
                        <p>Maaf, pembayaran Anda ditolak.</p>
                    @elseif ($do->status_pembayaran == 'completed')
                        <p>Anda sudah membayar. Code Order: {{ $do->order->code }}. Terima kasih!</p>
                    @else
                        <a href="{{ route('bayar', $do->id) }}" class="btn btn-primary">Bayar</a>
                        <a href="{{ route('batalkanpesanan', $do->id) }}" class="btn btn-danger" onclick="return confirm('Yakin untuk membatalkan???')">Batalkan Pesanan</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
