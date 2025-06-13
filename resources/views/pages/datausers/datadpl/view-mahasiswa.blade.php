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
                <a href="{{ route('datadpl') }}" class="btn btn-sm btn-primary">Kembali ke Data DPL</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-striped table-hover table align-middle">
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
                                            <!-- Jika ada link tugas, tampilkan tombol -->
                                            <a href="{{ $mhs->link }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">Lihat Tugas</a>
                                        @else
                                            <!-- Jika tidak ada link tugas, tampilkan '-' -->
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
                        </tbody>
                    </table>
                    {{ $datamahasiswas->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
