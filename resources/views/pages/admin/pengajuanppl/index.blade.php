@extends('layout.app')

@section('content')
    <div class="container">
        <h2>Data Pengajuan PPL</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Jurusan</th>
                    <th>Sekolah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuans as $pengajuan)
                    <tr>
                        <td>{{ $pengajuan->dataMahasiswa->nama }}</td>
                        <td>{{ $pengajuan->dataMahasiswa->jurusan }}</td>
                        <td>{{ $pengajuan->sekolah->nama_sekolah }}</td>
                        <td>{{ ucfirst($pengajuan->status) }}</td>
                        <td>
                            @if ($pengajuan->status == 'pending')
                                {{-- Tombol Approve --}}
                                <form action="{{ route('admin.pengajuan.ppl.update', [$pengajuan->id, 'approved']) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    <button class="btn btn-success btn-sm" type="submit">Approve</button>
                                </form>

                                {{-- Tombol Reject --}}
                                <form action="{{ route('admin.pengajuan.ppl.update', [$pengajuan->id, 'rejected']) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type="submit">Reject</button>
                                </form>
                            @elseif ($pengajuan->status == 'approved')
                                {{-- Kalau sudah di-approve, munculkan tombol lihat mahasiswa --}}
                                <a href="{{ route('datamahasiswaedit', ['id' => $pengajuan->data_mahasiswa_id]) }}"
                                    class="btn btn-primary btn-sm">
                                    Lihat Mahasiswa
                                </a>
                            @else
                                {{-- Kalau status rejected --}}
                                {{ ucfirst($pengajuan->status) }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr style="border: 2px solid #b6bcc1; background-color: white;">
                        <td class="text-center">Belum ada
                            tugas yang dikumpulkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $pengajuans->links() }}
    </div>
@endsection