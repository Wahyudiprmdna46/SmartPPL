<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show-PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h3 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h3>Histori Presensi Mahasiswa PPL - Bulan {{ $bulan }}, Tahun {{ $tahun }}</h3>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Nama Sekolah</th>
            <th>Tanggal Absen</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Foto Masuk</th>
            <th>Foto Keluar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($histori as $d)
            <tr>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->nim }}</td>
                <td>{{ $d->nama_sekolah }}</td>
                <td>{{ date('d-m-Y', strtotime($d->tgl_presensi ?? '-')) }}</td>
                <td>{{ $d->jam_in ?? '-' }}</td>
                <td>{{ $d->jam_out ?? '-' }}</td>
                <td>
                    @if($d->foto_in)
                        <a href="{{ asset('storage/uploads/absensi/' . $d->foto_in) }}">{{ $d->foto_in }}</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($d->foto_out)
                        <a href="{{ asset('storage/uploads/absensi/' . $d->foto_out) }}">{{ $d->foto_out }}</a>
                    @else
                        -
                    @endif
                </td>                
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
