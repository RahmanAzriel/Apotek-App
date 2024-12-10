<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #receipt {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 600px;
            background: #fff;
            border-radius: 8px;
            text-align: center;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
            margin: 0;
        }

        .header p {
            margin: 5px 0;
            color: #555;
        }

        .date {
            font-size: 1rem;
            color: #777;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .total-row {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .legal {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 15px;
        }

        /* CSS untuk menyembunyikan elemen saat pencetakan */
        @media print {
            .btn-back, .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div id="receipt">
        <div class="header">
            <h2>Apotek Jaya Abadi</h2>
            <p>Alamat: Sepanjang Jalan Kenangan</p>
            <p>Email: apotekjayaabadi@gmail.com | Telepon: 000-111-2222</p>
            <p class="date">Tanggal: {{ date('d-m-Y') }}</p> <!-- Menampilkan tanggal -->
            <p>Penanggung Jawab: {{ Auth::user()->name }}</p>
        </div>

        <hr>

        <table>
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order['medicines'] as $item)
                <tr>
                    <td>{{ $item['name_medicine'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>${{ number_format($item['price'], 2, '.', ',') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2">PPN 10%</td>
                    @php
                        $ppn = $order['total_price'] * 0.1;
                    @endphp
                    <td>${{ number_format($ppn, 2, '.', ',') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">Total</td>
                    <td>${{ number_format($order['total_price'] + $ppn, 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>

        <p class="legal"><strong>Terima kasih atas kunjungan Anda!</strong><br>Invoice ini dibuat secara otomatis dan sah tanpa tanda tangan dan cap.</p>
    </div>

</body>
</html>
