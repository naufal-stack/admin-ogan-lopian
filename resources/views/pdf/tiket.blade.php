<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Booking</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            padding: 30px;
        }

        .ticket {
            background-color: #ffffff;
            border-radius: 12px;
            border: 2px dashed #007BFF;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            overflow: hidden;
        }

        .header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px 30px;
        }

        .info {
            margin-bottom: 12px;
        }

        .info label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
            color: #333;
        }

        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            color: white;
            text-transform: capitalize;
        }

        .status.pending { background-color: #ffc107; }
        .status.confirmed { background-color: #28a745; }
        .status.cancelled { background-color: #dc3545; }
        .status.unpaid { background-color: #6c757d; }
        .status.paid { background-color: #198754; }

        .footer {
            background-color: #f1f1f1;
            text-align: center;
            font-size: 11px;
            color: #666;
            padding: 15px;
            border-top: 1px solid #ccc;
        }

        .branding {
            margin-top: 8px;
            font-weight: bold;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h2>E-TIKET WISATA</h2>
        </div>
        <div class="content">
            <div class="info">
                <label>Kode Booking:</label> {{ $booking->booking_code }}
            </div>
            <div class="info">
                <label>Nama Pengunjung:</label> {{ $booking->pengunjung }}
            </div>
            <div class="info">
                <label>Nama Wisata:</label> {{ $booking->nama_wisata }}
            </div>
            <div class="info">
                <label>Tanggal Kunjungan:</label> {{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}
            </div>
            <div class="info">
                <label>Dewasa:</label> {{ $booking->qty_dewasa }} orang
            </div>
            <div class="info">
                <label>Anak:</label> {{ $booking->qty_anak }} orang
            </div>
            <div class="info">
                <label>Total Harga:</label> Rp{{ number_format($booking->total_price, 0, ',', '.') }}
            </div>
            <div class="info">
                <label>Status:</label>
                <span class="status {{ $booking->status }}">{{ $booking->status }}</span>
            </div>
            <div class="info">
                <label>Pembayaran:</label>
                <span class="status {{ $booking->payment_status }}">{{ $booking->payment_status }}</span>
            </div>
        </div>
        <div class="footer">
            Harap tunjukkan e-tiket ini saat tiba di lokasi wisata.<br>
            <span class="branding">Powered by Ogan Lopian</span>
        </div>
    </div>
</body>
</html>
