@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-5">Data Mahasiswa</h1>
            <span class="lead">Kelola Data Mahasiswa</span>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0">Daftar Mahasiswa</h5>
                <!-- Button Kembali ke Data DPL di pojok kanan -->
                <a href="{{ route('datasekolah') }}" class="btn btn-sm btn-primary">Kembali ke Data Sekolah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-sm table-striped table-hover table align-middle"
                        style="border-collapse: collapse; width: 100%; 
           border: 4px double #2c3e50; 
           box-shadow: inset 0px 0px 10px rgba(0,0,0,0.2), 2px 2px 5px rgba(0,0,0,0.2); font-size: 1rem;">
                        <thead class="bg-dark text-center text-white">
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Jurusan</th>
                                <th>Nama Sekolah</th>
                                <th>Nama Pamong</th>
                                <th>Tugas</th>
                                <th>Nilai Mahasiswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($datamahasiswas->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-muted py-3 text-center">
                                        Data mahasiswa belum ada.
                                    </td>
                                </tr>
                            @else
                                @foreach ($datamahasiswas as $index => $mhs)
                                    <tr class="text-center">
                                        <td>{{ $index + $datamahasiswas->firstItem() }}</td>
                                        <td>{{ $mhs->nim }}</td>
                                        <td>{{ $mhs->nama }}</td>
                                        <td>{{ $mhs->jurusan }}</td>
                                        <td>{{ $mhs->dataSekolah?->nama_sekolah ?? '-' }}</td>
                                        <td>{{ $mhs->dataPamong?->nama ?? '-' }}</td>
                                        <td>
                                            @if ($mhs->link)
                                                <a href="{{ $mhs->link }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">Lihat Tugas</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($mhs->penilaian?->nilai_akhir ?? '-')
                                                <a href="{{ route('penilaian.index') }}"
                                                    class="text-gray-800 text-decoration-none">{{ $mhs->penilaian?->nilai_akhir ?? '-'}}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $datamahasiswas->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
