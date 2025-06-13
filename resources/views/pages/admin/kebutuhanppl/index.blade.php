@extends('layout.app')

@section('content')
    <div class="jumbotron mt-4">
        <h1 class="display-4">Data Kebutuhan PPL Sekolah</h1>
        <p>Kelola dan lihat kebutuhan PPL berdasarkan sekolah dan tahun ajaran.</p>
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

    {{-- FILTER TAHUN AJARAN --}}
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <form method="GET" action="{{ route('kuotappl') }}">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <select name="tahun_ajaran" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Tahun Ajaran --</option>
                            @foreach ($tahunAjaranList as $tahun)
                                <option value="{{ $tahun }}"
                                    {{ $request->tahun_ajaran == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        {{-- TABEL DATA --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-striped table-hover table align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Sekolah</th>
                            <th>Tahun Ajaran</th>
                            <th>Lihat Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kuotaBySekolah as $key => $group)
                            @php
                                $firstItem = $group->first();
                                [$sekolahId, $tahun] = explode('-', $key);
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $firstItem->sekolah->nama_sekolah ?? '-' }}</td>
                                <td class="text-center">{{ $tahun }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kebutuhanppl.detail', ['sekolah' => $sekolahId, 'tahun' => $tahun]) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                                <td class="text-center">
                                    <form
                                        action="{{ route('kebutuhanppl.deletePerSekolahTahun', ['sekolah' => $sekolahId, 'tahun' => $tahun]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus semua kebutuhan PPL untuk sekolah & tahun ajaran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
