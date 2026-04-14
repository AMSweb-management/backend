<!DOCTYPE html>
<html>

<head>
    <title>Laporan Bulanan</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }
    </style>
</head>

<body>

    <h2>Laporan Bulanan</h2>
    <p>Bulan: {{ $bulan }} / {{ $tahun }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barang_keluar as $item)
                <tr>
                    <td>{{ $item->obat->nama }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td>{{ $item->tanggal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Pendapatan: Rp {{ number_format($total, 0, ',', '.') }}</h3>

</body>

</html>
