@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-5">Data Mahasiswa</h1>
            <span class="lead">Nilai Akhir mahasiswa</span>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <div>
                    <a href="{{ route('nilaiakhir.export') }}" class="btn btn-success">
                        <i class="fas fa-file-download"></i> Export Data
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <table class="table-striped table-hover table align-middle"
                        style="border-collapse: collapse; width: 100%; border: 4px double #2c3e50; 
        box-shadow: inset 0px 0px 10px rgba(0,0,0,0.2), 2px 2px 5px rgba(0,0,0,0.2);">
                        <thead class="text-center"
                            style="background-color: #4f5963; color: white; 
           border-bottom: 3px solid #2c3e50;">
                            <tr class="align-middle">
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>DPL</th>
                                <th>Sekolah</th>
                                <th>Pamong</th>
                                <th>Nilai Pamong</th>
                                <th>Nilai DPL</th>
                                <th>Nilai Akhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datamahasiswas as $index => $mhs)
                                <tr style="border: 2px solid #2c3e50; background-color: white;">
                                    <td class="text-center">{{ $index + $datamahasiswas->firstItem() }}</td>
                                    <td class="text-center">{{ $mhs->nim }}</td>
                                    <td class="text-center">{{ $mhs->nama_mahasiswa }}</td>
                                    <td class="text-center">{{ $mhs->nama_dpl }}</td>
                                    <td class="text-center">{{ $mhs->nama_sekolah }}</td>
                                    <td class="text-center">{{ $mhs->nama_pamong }}</td>
                                    <td class="text-center">{{ $mhs->nilai_pamong }}</td>
                                    <td class="text-center">{{ $mhs->nilai_dpl }}</td>
                                    <td class="text-center">{{ $mhs->nilai_akhir }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('nilaiakhir.destroy', $mhs->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus nilai akhir mahasiswa ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
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
