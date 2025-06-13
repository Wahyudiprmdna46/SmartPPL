@php
    $jurusan = $data->dataMahasiswa->jurusan;
    switch ($jurusan) {
        case 'PTIK':
            $namaProdi = 'Pendidikan Teknik Informatika (PTIK)';
            break;
        case 'PAI':
            $namaProdi = 'Pendidikan Agama Islam (PAI)';
            break;
        case 'PBA':
            $namaProdi = 'Pendidikan Bahasa Arab (PBA)';
            break;
        case 'PBI':
            $namaProdi = 'Pendidikan Bahasa Inggris (PBI)';
            break;
        case 'PMTK':
            $namaProdi = 'Pendidikan Matematika (PMTK)';
            break;
        case 'BK':
            $namaProdi = 'Bimbingan Konseling (BK)';
            break;
        default:
            $namaProdi = $jurusan;
    }
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Laporan Penilaian Mahasiswa</title>
    <style>

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        .no-border {
            border: none;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center">
        DAFTAR NILAI PERSIAPAN MENGAJAR, PRAKTEK MENGAJAR DAN <br />
        LAPORAN PRAKTEK PENGALAMAN LAPANGAN (PPL)
    </h3>

    <table class="no-border" style="width: 80%; border-collapse: collapse; margin: 20px auto 0 auto;">
        <tr class="no-border">
            <td class="no-border" style="width: 150px">Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $data->dataMahasiswa->nama }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border" style="width: 150px">NIM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $data->dataMahasiswa->nim }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border" style="width: 150px">Prodi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $namaProdi }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border" style="width: 150px">Satuan Pdd &nbsp;&nbsp;&nbsp; : {{ $data->dataMahasiswa->dataPamong->dataSekolah->nama_sekolah ?? '-' }}</td>
        </tr>
    </table>
    

    <table style="width: 70%; border-collapse: collapse; margin: 20px auto 0 auto;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="width: 5%; border: 1px solid #000; padding: 6px; text-align: center;">No</th>
                <th style="width: 50%; border: 1px solid #000; padding: 6px; text-align: left;">Aspek Penilaian</th>
                <th style="width: 8%; border: 1px solid #000; padding: 6px; text-align: center;">Nilai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">1</td>
                <td style="border: 1px solid #000; padding: 6px;">Persiapan Mengajar</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $data->persiapan_mengajar }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">2</td>
                <td style="border: 1px solid #000; padding: 6px;">Praktek Mengajar</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $data->praktek_mengajar }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">3</td>
                <td style="border: 1px solid #000; padding: 6px;">Laporan Akhir</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $data->laporan_ppl }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #000; padding: 6px; text-align: center;"><strong>Nilai
                        Akhir</strong></td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">
                    <strong>{{ $data->nilai_akhir }}</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="margin-left: 105px">
    <p><strong>Catatan:</strong> {{ $data->catatan }}</p>
    </div>

    <br><br><br>
    <div style="margin-left: 375px">
        {{ $data->dataMahasiswa->dataPamong->dataSekolah->kota ?? '-' }},
        ..........................................
        {{ date('Y') }}
    </div>
    <br>

    <div style="margin-left: 460px">
        Guru Pamong
    </div>

    <br><br><br><br>
    <div style="margin-left: 455px">
        {{ $data->dataMahasiswa->dataPamong->nama }}
    </div>
    <br>
    <div style="margin-left: 375px"> NIP.  {{ $data->dataMahasiswa->dataPamong->nip }}</div>
</body>

</html>
