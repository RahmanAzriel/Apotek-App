<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        #receipt {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 50px auto;
            max-width: 700px;
            background: #FFF;
            border-radius: 8px;
        }

        .btn-back, .btn-print {
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            padding: 10px 15px;
        }

        .btn-back {
            background-color: #6c757d;
        }

        .btn-print {
            background-color: #28a745;
            cursor: pointer;
        }

        #top .info h2 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        p, h2 {
            margin: 0;
        }

        .info p {
            color: #555;
            font-size: 0.9rem;
        }

        .table th, .table td {
            padding: 10px;
            text-align: center;
            font-size: 0.9rem;
        }

        .table th {
            background-color: #f1f1f1;
        }

        .total-row {
            font-weight: bold;
        }

        .legal {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 15px;
            text-align: center;
        }

        .footer-note {
            font-size: 0.8rem;
            color: #555;
        }

        /* CSS untuk menyembunyikan elemen saat pencetakan */
        @media print {
            .btn-back, .btn-print, .container.mt-4.text-right {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container mt-4 text-right">
        <a href="{{ route('purchase.index') }}" class="btn btn-back">Kembali</a>
    </div>

    <div id="receipt" class="container mt-4">
        <div class="text-right mb-3">
            <button onclick="window.print()" class="btn btn-print">Cetak (.pdf)</button>
        </div>

        <center id="top">
            <div class="info">
                <h2>Apotek Jaya Abadi</h2>
                <p class="mt-1">Alamat: sepanjang jalan kenangan</p>
                <p>Email: apotekjayaabadi@gmail.com | Phone: 000-111-2222</p>
            </div>
        </center>

        <hr>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Price</th>
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
                <tr>
                    <td colspan="2">PPN 10%</td>
                    @php
                        $ppn = $order['total_price'] * 0.1;
                    @endphp
                    <td>${{ number_format($ppn, 2, '.', ',') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">Total</td>
                    <td>${{ number_format($item['total_price'] + $ppn, 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>

        <p class="legal"><strong>Thank you for your business!</strong><br>Invoice was created on a computer and is valid without the signature and seal.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
