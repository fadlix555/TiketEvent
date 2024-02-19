@extends('template.html')

@section('title', 'Admin Pending Orders')

@section('body')
@include('template.navadmin')
<div class="container mtp">
    <div class="card card-body">
        <h2 class="text-center mb-4"> Pesanan </h2>

        <table class="table table-active" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode Order</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nama Event</th>
                    <th>Tiket</th>
                    <th>Bayar</th>
                    <th>Status</th>
                    <th>Bukti</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingOrders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $order->created_at->format('Y-m-d') }}
                    </td>
                    <td>{{ $order->code }}</td> 
                    <td>
                        @foreach ($order->detailOrders as $detailOrder)
                            {{ $detailOrder->user->nama }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($order->detailOrders as $detailOrder)
                            {{ $detailOrder->user->email }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($order->detailOrders as $detailOrder)
                            {{ $detailOrder->event->nama }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($order->detailOrders as $detailOrder)
                            {{ $detailOrder->qty }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($order->detailOrders as $detailOrder)
                            Rp {{ number_format($detailOrder->pricetotal, 0, ',', '.' ) }} <br>
                        @endforeach
                    </td>
                    <td width="300">
                        @if (auth()->user()->isAdmin())
                            @foreach ($order->detailOrders as $detailOrder)
                                {{ $detailOrder->status_pembayaran }} <br>
                            @endforeach
                        @else
                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            <div class="d-flex gap-2">
                                <select name="status_pembayaran" id="status_pembayaran" class="form-control mb-2 w-50">
                                    <option value="pending" selected>Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                <button type="submit" class="btn btn-outline-dark"> Konfirmasi </button>
                            </div>
                        </form>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-dark m-auto" data-bs-toggle="modal" data-bs-target="#orderModal">
                            Lihat Foto
                        </button>
                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> Bukti Pembayaran </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                @foreach ($order->detailOrders as $detailOrder)
                                    <img src="{{ asset($detailOrder->bukti_pembayaran) }}" alt="Proof of Payment" style="max-width: 100%;">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#example', {
        responsive: true

    });
</script>
@endsection
