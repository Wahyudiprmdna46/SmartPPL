@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-5">Data Mahasiswa</h1>
            <span class="lead">Pengelolaan Data Mahasiswa</span>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0">Ubah Data Mahasiswa</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- @if ($errors->any())
                        @dd($errors->all())
                    @endif --}}
                    <form action="{{ route('datamahasiswaupdate', $datamahasiswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" name="nim" id="nim"
                                        class="form-control @error('nim') is-invalid @enderror"
                                        value="{{ old('nim', $datamahasiswa->nim) }}">
                                    @error('nim')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $datamahasiswa->nama) }}">
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin"
                                        class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="L"
                                            {{ old('jenis_kelamin', $datamahasiswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="P"
                                            {{ old('jenis_kelamin', $datamahasiswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <input type="text" name="jurusan" id="jurusan"
                                        class="form-control @error('jurusan') is-invalid @enderror"
                                        value="{{ old('jurusan', $datamahasiswa->jurusan) }}">
                                    @error('jurusan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="dpl_id" class="form-label">DPL</label>
                                    <select name="dpl_id" id="dpl_id"
                                        class="form-control @error('dpl_id') is-invalid @enderror">
                                        @foreach ($dpls as $dpl)
                                            <option value="{{ $dpl->id }}"
                                                {{ old('dpl_id', $datamahasiswa->dpl_id ?? '') == $dpl->id ? 'selected' : '' }}>
                                                {{ $dpl->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('dpl_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="sekolah_id" class="form-label">Sekolah</label>
                                    <select name="sekolah_id" id="sekolah_id"
                                        class="form-control @error('sekolah_id') is-invalid @enderror">
                                        @foreach ($sekolahs as $sekolah)
                                            <option value="{{ $sekolah->id }}"
                                                {{ old('sekolah_id', $datamahasiswa->sekolah_id ?? '') == $sekolah->id ? 'selected' : '' }}>
                                                {{ $sekolah->nama_sekolah }}</option>
                                        @endforeach
                                    </select>
                                    @error('sekolah_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pamong_id" class="form-label">Pamong</label>
                                    <select name="pamong_id" id="pamong_id"
                                        class="form-control @error('pamong_id') is-invalid @enderror">
                                        <option value="">-- Pilih Pamong --</option>
                                        @foreach ($pamongs as $pamong)
                                            <option value="{{ $pamong->id }}"
                                                {{ old('pamong_id', $datamahasiswa->pamong_id ?? '') == $pamong->id ? 'selected' : '' }}>
                                                {{ $pamong->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('pamong_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('datamahasiswa') }}"
                                        class="btn btn-sm btn-outline-secondary mr-2">Batal</a>
                                    <button type="submit" class="btn btn-sm btn-warning">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {
            $('#pamong_id').select2({
                placeholder: 'Cari Pamong...',
                allowClear: true
            });
            $('#dpl_id').select2({
                placeholder: 'Cari DPL...',
                allowClear: true
            });
            $('#sekolah_id').select2({
                placeholder: 'Cari Sekolah...',
                allowClear: true
            });
        });
    </script>
@endpush
