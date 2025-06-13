@extends('layout.app')

@section('content')
    <div class="jumbotron mt-4">
        <h1 class="display-5">{{ $sekolah->nama_sekolah }}</h1>
        <p><strong>Tahun Ajaran:</strong> {{ $tahun }}</p>
    </div>

    {{-- ALERTS --}}
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

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            <strong>Detail Kuota PPL</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Jurusan</th>
                            <th>Kuota Mahasiswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kuotaList as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->jurusan }}</td>
                                <td>{{ $item->jumlah_mahasiswa }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data kuota untuk tahun ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('kuotappl') }}" class="btn btn-secondary mt-3">
                ⬅️ Kembali
            </a>
        </div>
    </div>
@endsection