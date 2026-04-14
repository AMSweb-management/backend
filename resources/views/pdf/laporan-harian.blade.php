<!DOCTYPE html>
<html>
<head>
    <title>Laporan Harian</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>

<h2>Laporan Harian</h2>
<p>Tanggal: {{ $tanggal }}</p>

<h3>Barang Keluar</h3>
<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang_keluar as $item)
        <tr>
            <td>{{ $item->obat->nama }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>Rp {{ number_format($item->total) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Total Pendapatan: Rp {{ number_format($total) }}</h3>

<h3>Stok Menipis</h3>
<ul>
    @foreach ($stok_menipis as $item)
        <li>{{ $item->nama }} (Sisa: {{ $item->stok }})</li>
    @endforeach
</ul>

</body>
</html>