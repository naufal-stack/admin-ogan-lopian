<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Detail</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Detail Pemesanan</h2>

    <p><strong>Kode Booking:</strong> {{ $booking->booking_code }}</p>
    <p><strong>Nama Pengunjung:</strong> {{ $booking->pengunjung }}</p>
    <p><strong>Wisata:</strong> {{ $booking->nama_wisata }}</p>
    <p><strong>Tanggal:</strong> {{ $booking->tanggal }}</p>
    <p><strong>Jumlah Dewasa:</strong> {{ $booking->qty_dewasa }}</p>
    <p><strong>Jumlah Anak:</strong> {{ $booking->qty_anak }}</p>
    <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
    <p><strong>Pembayaran:</strong> {{ ucfirst($booking->payment_status) }}</p>
</body>
</html>
