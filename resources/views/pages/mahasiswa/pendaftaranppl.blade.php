@extends('layout.app')

@section('content')
    <div class="container">
        <h2>Form Pendaftaran PPL</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Cek jika sudah diterima entah dari pengajuan atau manual --}}
        @if (($pengajuan && $pengajuan->status == 'approved') || $sudahDiterima)
            <div class="alert alert-info">
                <strong>Info:</strong> Anda telah diterima di
                <strong>{{ $pengajuan->sekolah->nama_sekolah ?? ($dataMahasiswa->dataSekolah->nama_sekolah ?? '-') }}</strong>.
                Formulir pendaftaran tidak tersedia lagi.
            </div>
        @else
            {{-- Formulir hanya tampil jika belum approved --}}
            <form action="{{ route('pendaftaran.ppl.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="sekolah_id">Pilih Sekolah</label>
                    <select name="sekolah_id" id="sekolah_id" class="form-control" required>
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach ($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Ajukan PPL</button>
            </form>
        @endif

        {{-- Info Pengajuan PPL --}}
        @if ($pengajuan)
            <div class="card mt-4">
                <div class="card-header">Informasi Pengajuan PPL Anda</div>
                <div class="card-body">
                    <table class="table-striped table">
                        <thead>
                            <tr>
                                <th>Sekolah</th>
                                <th>Status</th>
                                <th>Tanggal Diajukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $pengajuan->sekolah->nama_sekolah ?? '-' }}</td>
                                <td>
                                    @if ($pengajuan->status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                    @elseif($pengajuan->status == 'approved')
                                        <span class="badge bg-success text-light">Disetujui</span>
                                    @elseif($pengajuan->status == 'rejected')
                                        <span class="badge bg-danger text-light">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- Pesan tambahan jika rejected --}}
                    @if ($pengajuan->status == 'rejected')
                        <div class="alert alert-warning mt-3">
                            Pengajuan Anda sebelumnya <strong>ditolak</strong>. Silakan ajukan ulang memilih sekolah lain.
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {
            $('#sekolah_id').select2({
                placeholder: 'Cari Sekolah...',
                allowClear: true
            });
        });
    </script>
@endpush
