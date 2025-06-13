@extends('layout.app')

@section('content')
    <div class="jumbotron mt-4">
        <h1 class="display-4">Data Kuota PPL</h1>
        <p>Kelola kebutuhan kuota per jurusan yang diajukan oleh sekolah Anda.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{ route('kuotappl.create') }}" class="btn btn-primary"
                        {{ $jumlahJurusan >= 6 ? 'disabled' : '' }}>
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <form method="GET" action="{{ route('kuotappl') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="tahun_ajaran" class="form-select" onchange="this.form.submit()">
                                        <option value="">-- Semua Tahun Ajaran --</option>
                                        @foreach ($tahunAjaranList as $tahun)
                                            <option value="{{ $tahun }}"
                                                {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>
                                                {{ $tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        <table class="table-striped table-hover table align-middle"
                            style="border-collapse: collapse; width: 100%; border: 4px double #2c3e50; 
                            box-shadow: inset 0px 0px 10px rgba(0,0,0,0.2), 2px 2px 5px rgba(0,0,0,0.2);">
                            <thead class="text-center"
                                style="background-color: #4f5963; color: white; 
                               border-bottom: 3px solid #2c3e50;">
                                <tr class="align-middle">
                                    <th>No</th>
                                    <th>Nama Sekolah</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Jurusan</th>
                                    <th>Kuota Mahasiswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kuotappls as $index => $kuota)
                                    <tr style="border: 2px solid #2c3e50; background-color: white;">
                                        <td class="text-center">{{ $index + $kuotappls->firstItem() }}</td>
                                        <td class="text-center">{{ $kuota->sekolah->nama_sekolah ?? '-' }}</td>
                                        <td class="text-center">{{ $kuota->tahun_ajaran }}</td>
                                        <td class="text-center">{{ $kuota->jurusan }}</td>
                                        <td class="text-center">{{ $kuota->jumlah_mahasiswa }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="#" class="btn btn-sm btn-warning mr-2">Ubah</a>
                                                <form action="{{ route('kuotappl.delete', $kuota->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Belum ada data kuota PPL.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $kuotappls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
