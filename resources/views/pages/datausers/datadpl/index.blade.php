@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-5">Data DPL</h1>
            <span class="lead">Pengelolaan Data DPL</span>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                {{-- Search Form --}}
                <form method="GET" action="{{ route('datadpl') }}" class="d-flex align-items-center gap-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIP..."
                            value="{{ request('search') }}">

                        @if (request('search'))
                            <a href="{{ route('datadpl') }}" class="btn btn-outline-secondary">
                                &times;
                            </a>
                        @endif

                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                <div>
                    <!-- Tombol untuk membuka modal -->
                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                        data-bs-target="#importExcelModal">
                        <i class="fas fa-file-excel"></i> Import Excel
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importExcelModalLabel">Import Excel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('importexceldpl') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="file">Pilih File Excel</label>
                                            <input type="file" id="file" name="file" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('datadplcreate') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>

                    <a href="{{ route('exportexceldpl') }}" class="btn btn-success">
                        <i class="fas fa-file-download"></i> Export Data
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    @if (session('header_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error saat import:</strong>
                            <ul>
                                @foreach (session('header_error') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('duplicate_error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Duplikat data:</strong>
                            <ul>
                                @foreach (session('duplicate_error') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

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
                            style="background-color: #4f5963; color: white; border-bottom: 3px solid #2c3e50;">
                            <tr class="align-middle">
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Golongan</th>
                                <th>Jabatan</th>
                                <th>Jenis Kelamin</th>
                                <th>Mahasiswa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datadpls as $index => $datadpl)
                                <tr style="border: 2px solid #2c3e50; background-color: white;">
                                    <td class="text-center">{{ $index + $datadpls->firstItem() }}</td>
                                    <td class="text-center">{{ $datadpl->nip }}</td>
                                    <td class="text-center">{{ $datadpl->nama }}</td>
                                    <td class="text-center">{{ $datadpl->golongan }}</td>
                                    <td class="text-center">{{ $datadpl->jabatan }}</td>
                                    <td class="text-center">{{ $datadpl->jenis_kelamin }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('viewmahasiswa', ['id' => $datadpl->id]) }}"
                                            class="btn btn-sm btn-primary mr-2">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex">
                                            <a href="{{ route('datadpledit', $datadpl->id) }}"
                                                class="btn btn-sm btn-warning mr-2">Ubah</a>
                                            <form action="{{ route('datadpldelete', $datadpl->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $datadpls->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
