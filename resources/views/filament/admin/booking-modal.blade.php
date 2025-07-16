<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 30px;
        }

        .ticket {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border: 2px dashed #2c3e50;
            border-radius: 10px;
            padding: 20px 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #bbb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            color: #2c3e50;
        }

        .booking-info {
            line-height: 1.8;
        }

        .label {
            font-weight: bold;
            color: #34495e;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h2>Tiket Wisata</h2>
            <p><strong>Kode Booking:</strong> {{ $record->booking_code }}</p>
        </div>

        <div class="booking-info">
            <p><span class="label">Nama Pengunjung:</span> {{ $record->pengunjung }}</p>
            <p><span class="label">Wisata:</span> {{ $record->nama_wisata }}</p>
            <p><span class="label">Tanggal Kunjungan:</span> {{ \Carbon\Carbon::parse($record->tanggal)->format('d M Y') }}</p>
            <p><span class="label">Jumlah Dewasa:</span> {{ $record->qty_dewasa }}</p>
            <p><span class="label">Jumlah Anak:</span> {{ $record->qty_anak }}</p>
            <p><span class="label">Total Harga:</span> Rp{{ number_format($record->total_price, 0, ',', '.') }}</p>
            <p><span class="label">Status Pembayaran:</span> {{ ucfirst($record->payment_status) }}</p>
            <p><span class="label">Status Tiket:</span> {{ ucfirst($record->status) }}</p>
        </div>

        <div class="footer">
            Silakan tunjukkan tiket ini saat masuk ke tempat wisata.
        </div>
    </div>
</body>
</html>
