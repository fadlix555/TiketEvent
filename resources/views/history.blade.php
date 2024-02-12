@extends('template.html')

@section('title', 'History User')

@section('body')
@include('template.nav')
<div class="container mtp">
    <h2> History Pembelian </h2>
    @if (Session::has('notif'))
        <div class="alert alert-success">{{ Session::get('notif') }}</div>
    @endif
    @foreach ($orderHistory as $do)
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset($do->Event->foto) }}" class="img-fluid" style="margin-top: 25%">
                </div>
                <div class="col-md-9">
                    <p><strong>Event:</strong> {{ $do->Event->nama }}</p>
                    <p><strong>Tanggal:</strong> {{ $do->Event->tanggal }}</p>
                    <p><strong>Waktu:</strong> {{ $do->Event->waktu }}</p>
                    <p><strong>Tempat:</strong> {{ $do->Event->lokasi }}</p>
                    <p><strong>Jumlah Tiket:</strong> {{ $do->qty }}</p>
                    <p><strong>Total Harga:</strong> Rp.{{ number_format($do->pricetotal, 0, '.', '.') }}</p>
                    <p><strong>Status Pembayaran:</strong> {{ $do->status_pembayaran }}</p>

                    @if ($do->status_pembayaran === 'completed')
                        <p>Pembayaran sudah di konfirmasi</p>
                        <hr>
                        <a href="{{ route('printInvoiceTicket', $do->id) }}" class="btn btn-primary"> Cetak Invoice</a>
                    @elseif ($do->status_pembayaran === 'rejected')
                        <p>Maaf, pembayaran Anda ditolak.</p>
                    @elseif ($do->status_pembayaran === 'pending' && $do->bukti_pembayaran)
                        <p>Pembayaran selesai. Menunggu konfirmasi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection