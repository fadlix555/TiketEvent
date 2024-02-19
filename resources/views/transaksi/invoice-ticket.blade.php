<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            margin: 20px;
        }
        h3 {
            text-align: center;
            color: #333;
        }
        h2 {
            text-align: right;
            color: #333;
        }
        .invoice-details {
            margin-bottom: 25px;
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
    <p>
        <h1>Invoice</h1>
        <h2>Tivent</h2>
    </p>

    <div class="invoice-details">
        <p>Nama: {{ $detailOrder->user->nama }}</p>
        <p>Email: {{ $detailOrder->user->email }}</p>
        <p>Order Code: {{ $detailOrder->order->code }}</p>
        <p>{{ $detailOrder->event->nama }}</p>
        <p>Tanggal : {{ $detailOrder->event->tanggal }}</p>
        <p>Waktu : {{ $detailOrder->event->waktu }}</p>
        <p>Lokasi : {{ $detailOrder->event->lokasi }}</p>
    </div>

    <hr>

    <table>
        <thead>
            <tr>
                <th>Tiket yang di beli: </th>
                <th>Harga Tiket:</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $detailOrder->qty }}</td>                     
                    <td>{{ number_format($detailOrder->event->harga, 0, ',', '.') }}</td>
                    <!-- Add more columns as needed -->
                </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>Total Harga :</td>
                <td>{{ number_format($detailOrder->pricetotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <hr>

    <footer> 
        <h3>-----Terima Kasih Telah Membeli tiket di website kami-----</h3>
    </footer>

</body>
</html>
