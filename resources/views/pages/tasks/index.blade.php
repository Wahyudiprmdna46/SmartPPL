@extends('layout.app')
@section('content')
    <div class="jumbotron mt-3">
        <h1 class="display-4">Daftar Tugas Mahasiswa</h1>
        <p>Pengumpulan Tugas mahasiswa ppl</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="card">
                <div class= "card-header d-flex justify-content-end">
                    <!-- Tombol untuk membuka modal -->
                    @if ($isMahasiswa)
                        @php
                            $sudahUpload = $tasks->where('nim', Auth::user()->nim)->isNotEmpty();
                        @endphp

                        @if (!$sudahUpload)
                            <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                data-bs-target="#tugasModal">
                                <i class="fas fa-plus"></i> Upload Tugas
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary me-3" disabled>
                                <i class="fas fa-ban"></i> Sudah Upload
                            </button>
                        @endif
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table-hover table align-middle"
                            style="border-collapse: collapse; width: 100%; border: 4px double #2c3e50; 
                            box-shadow: inset 0px 0px 10px rgba(0,0,0,0.2), 2px 2px 5px rgba(0,0,0,0.2);">
                            <thead class="text-center"
                                style="background-color: #4f5963; color: white; border-bottom: 3px solid #2c3e50;">
                                <tr class="align-middle">
                                    <th>No</th>
                                    <th>Nim</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Link Tugas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr style="border: 2px solid #2c3e50; background-color: white;">
                                        <td class="text-center">
                                            {{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            {{ $task->nim }}</td>
                                        <td class="text-center">
                                            {{ $task->nama }}</td>
                                        <td class="text-center">
                                            {{ $task->jurusan }}</td>
                                        <td class="text-center">
                                            <a href="{{ $task->link }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">Lihat Tugas</a>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if ($isMahasiswa)
                                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                                        class="btn btn-sm btn-warning mr-2">
                                                        Ubah
                                                    </a>
                                                @endif
                                        
                                                @if ($isMahasiswa || $isAdminMahasiswa)
                                                    <form action="{{ route('tasks.delete', $task->id) }}" method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>                                        
                                    </tr>
                                @empty
                                    <tr style="border: 2px solid #2c3e50; background-color: white;">
                                        <td class="text-center">Belum ada
                                            tugas yang dikumpulkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- {{ $tasks->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tugasModal" tabindex="-1" aria-labelledby="tugasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tugasModalLabel">Upload Tugas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tasks" class="form-label">Link Google Drive</label>
                            <input type="text" name="tasks" id="tasks"
                                class="form-control @error('tasks') is-invalid @enderror" value="{{ old('tasks') }}">
                            @error('tasks')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to open modal if needed -->
    @if (session('open_modal') || $errors->has('tasks'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = new bootstrap.Modal(document.getElementById('tugasModal'));
                modal.show();
            });
        </script>
    @endif
@endsection
