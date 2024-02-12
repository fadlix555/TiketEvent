@extends('template.html')

@section('title', 'Admin Pending Orders')

@section('body')
@include('template.navadmin')
<div class="container mtp">
    <h2 class="text-center mb-4">Pending Orders</h2>

        <table class="table table-primary" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Order Code</th>
                    <th>Nama Event</th>
                    <th>Email Costumer</th>
                    <th>Status Pembayaran</th>
                    <th>Foto Bukti Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingOrders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->code }}</td>
                    <td>
                        @foreach ($order->detailOrders as $detailOrder)
                            {{ $detailOrder->event->nama }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($order->detailOrders as $detailOrder)
                            {{ $detailOrder->user->email }} <br>
                        @endforeach
                    </td>
                    <td width="300">
                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            <div class="d-flex gap-2">
                                <select name="status_pembayaran" id="status_pembayaran" class="form-control mb-2 w-50">
                                    <option value="pending" selected>Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                <button type="submit" class="btn btn-primary"> Konfirmasi </button>
                            </div>
                        </form>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary m-auto" data-bs-toggle="modal" data-bs-target="#orderModal">
                            Lihat Foto
                        </button>
                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Proof of Payment</h5>
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
