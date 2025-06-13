@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-5">Penugasan Mahasiswa PPL</h1>
            <span class="lead">Pengelolaan Tugas Mahasiswa PPL</span>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0">Daftar Tugas</h5>
                <a href="#" class="btn btn-success">
                    <i class="fas fa-download"></i> Unduh Data
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-striped table-hover table align-middle"
                        style="border-collapse: collapse; width: 100%; 
                           border: 4px double #2c3e50; 
                           box-shadow: inset 0px 0px 10px rgba(0,0,0,0.2), 2px 2px 5px rgba(0,0,0,0.2);">
                        <thead class="text-center"
                            style="background-color: #4f5963; color: white; 
                               border-bottom: 3px solid #2c3e50;">
                            <tr class="align-middle">
                                <th style="border: 2px solid #2c3e50; padding: 10px;">No</th>
                                <th style="border: 2px solid #2c3e50; padding: 10px;">NIM</th>
                                <th style="border: 2px solid #2c3e50; padding: 10px;">Nama</th>
                                <th style="border: 2px solid #2c3e50; padding: 10px;">Nama Sekolah</th>
                                <th style="border: 2px solid #2c3e50; padding: 10px;">Pamong</th>
                                <th style="border: 2px solid #2c3e50; padding: 10px;">Laporan Akhir</th>
                                <th style="border: 2px solid #2c3e50; padding: 10px;">Video Mengajar</th>
                                <th style="border: 2px solid #2c3e50; padding: 10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($datadpls as $datadpl) --}}
                            <tr style="border: 2px solid #2c3e50; background-color: white;">
                                <td class="text-center" style="border: 2px solid #2c3e50; padding: 10px;">
                                    NO</td>
                                <td class="text-center" style="border: 2px solid #2c3e50; padding: 10px;">
                                    NIM</td>
                                <td class="text-center" style="border: 2px solid #2c3e50; padding: 10px;">
                                    Nama</td>
                                <td class="text-center" style="border: 2px solid #2c3e50; padding: 10px;">
                                    Nama Sekolah</td>
                                <td class="text-center" style="border: 2px solid #2c3e50; padding: 10px;">
                                    Pamong</td>
                                <td class="text-center" style="border: 2px solid #2c3e50; padding: 10px;">
                                    Laporan Akhir</td>
                                <td class="text-center" style="border: 2px solid #2c3e50; padding: 10px;">
                                    Video Mengajar</td>
                                <td class="text-center" style="border: 2px solid #2c3e50; padding: 10px;">
                                    {{-- <div class="d-flex">
                                            <a href="{{ route('datadpledit', $datadpl->id) }}" class="btn btn-sm btn-warning mr-2">
                                                Ubah
                                            </a>
                                            <form action="{{ route('datadpldelete', $datadpl->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div> --}}
                                </td>
                            </tr>
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
