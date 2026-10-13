<!DOCTYPE html>
<html>
<head>
    <title>Daftar Armada</title>
</head>
<body>
    <h1>Daftar Kendaran Rental</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nama Kendaraan</th>
            <th>Tipe</th>
            <th>Harga Sewa</th>
            <th>Status</th>
        </tr>
        @foreach($armadas as $mobil)
        <tr>
            <td>{{ $mobil->nama_kendaraan }}</td>
            <td>{{ $mobil->tipe }}</td>
            <td>Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}</td>
            <td>{{ $mobil->status_ketersediaan }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>