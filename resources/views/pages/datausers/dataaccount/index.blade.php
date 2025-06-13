@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-5">Account Users</h1>
            <span class="lead">Pengelolaan Account Users</span>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                {{-- Search Form --}}
                <form method="GET" action="{{ route('admin.account') }}" class="d-flex align-items-center gap-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nama, NIM, NIP, NIK, atau NPSN..." value="{{ request('search') }}">

                        @if (request('search'))
                            <a href="{{ route('admin.account') }}" class="btn btn-outline-secondary">
                                &times;
                            </a>
                        @endif

                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                <a href="{{ route('accountcreate') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
                {{-- <div>
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
                </div> --}}
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
                            style="background-color: #4f5963; color: white; border-bottom: 3px solid #2c3e50;">
                            <tr class="align-middle">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIM</th>
                                <th>NIP</th>
                                <th>NIK</th>
                                <th>NPSN</th>
                                <th>Role</th>
                                <th>Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataaccounts as $index => $account)
                                <tr style="border: 2px solid #2c3e50; background-color: white;">
                                    <td class="text-center">{{ $index + $dataaccounts->firstItem() }}</td>
                                    <td class="text-center">{{ $account->name }}</td>
                                    <td class="text-center">{{ $account->email }}</td>
                                    <td class="text-center">{{ $account->nim ?? '-' }}</td>
                                    <td class="text-center">{{ $account->nip ?? '-' }}</td>
                                    <td class="text-center">{{ $account->nik ?? '-' }}</td>
                                    <td class="text-center">{{ $account->npsn ?? '-' }}</td>
                                    <td class="text-center">{{ $account->role }}</td>
                                    <td class="text-center">{{ $account->password }}</td>
                                    <td class="text-center">
                                        <div class="d-flex">
                                            <a href= "{{ route('accountedit', $account->id) }}"
                                                class="btn btn-sm btn-warning mr-2">Ubah</a>
                                            <form action="{{ route('accountdelete', $account->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $dataaccounts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
