<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi PDF</title>
    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan untuk tampilan PDF */
        body {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Riwayat Transaksi</h2>

<table>
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
        @foreach ($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->created_at }}</td>
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
            <td colspan="5">Total:</td>
            <td>Rp. {{ number_format($totalPrice, 0, ',', '.') }}</td> <!-- Menampilkan total harga dari semua order -->
        </tr>
    </tfoot>
</table>

</body>
</html>
