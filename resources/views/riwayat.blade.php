<!-- resources/views/admin/completed-rejected-orders.blade.php -->
@extends('template.html')

@section('title', 'Riwayat Transaksi')

@section('body')

@include('template.navadmin')

<div class="container mtp">
    <h2 class="text-center mb-3">Riwayat Transaksi</h2>
    
    <div class="card col-12 p-3 mb-4 me-3" style="height: 80px">
        <form action="{{ route('riwayat') }}" class="form-group">
            <div class="mb-2 d-flex">
                <label for="start_date">Tanggal Awal:</label>
                <input type="date" id="start_date" name="start_date" class="form-control w-50 me-3">
                <label for="end_date">Tanggal Akhir:</label>
                <input type="date" id="end_date" name="end_date" class="form-control w-50 me-3 mb-2">
                <button type="submit" class="btn btn-primary me-3">Search</button>
            </div>
        </form>
    </div>
    <div class="card col-12 p-3 mb-4" style="height: 85px">
        <form action="{{ route('printRiwayatTransaksi') }}" class="form-group">
            <div class="mb-2 d-flex">
                <label for="start_date">Tanggal Awal:</label>
                <input type="date" id="start_date" name="start_date" class="form-control w-50 me-3">
                <label for="end_date">Tanggal Akhir:</label>
                <input type="date" id="end_date" name="end_date" class="form-control w-50 me-3 mb-2">
                <button type="submit" class="btn btn-danger me-3">ExportPDf</button>
            </div>
        </form>
    </div>

    <table class="table table-primary mt-3" id="example">
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu Pembayaran</th>
                <th>Order Code</th>
                <th>Event Name</th>
                <th>Status Pembayaran</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPrice = 0; @endphp <!-- Inisialisasi total harga -->
            @foreach ($completedRejectedOrders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $order->created_at }}
                    </td>
                    <td>{{ $order->code }}</td>
                    <td>
                        @foreach ($order->detailOrders as $detailOrder)
                            {{ $detailOrder->event->nama }}
                        @endforeach
                    </td>
                    <td>
                        @foreach ($order->detailOrders as $detailOrder)
                            {{ $detailOrder->status_pembayaran }}
                        @endforeach
                    </td>
                    <td>
                        @php
                            $orderTotal = 0; // Total harga per order
                        @endphp
                        @foreach ($order->detailOrders as $detailOrder)
                            @php
                                $orderTotal += $detailOrder->pricetotal; // Menambahkan harga detail order ke total order
                                $totalPrice += $detailOrder->pricetotal; // Menambahkan harga detail order ke total harga
                            @endphp
                        @endforeach
                        Rp. {{ number_format($orderTotal, 0, ',', '.') }} <!-- Menampilkan total harga order -->
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="border-top-0" colspan="5">Total:</td>
                <td class="border-top-0">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</td> <!-- Menampilkan total harga dari semua order -->
            </tr>
        </tfoot>
    </table>
</div>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
@endsection
