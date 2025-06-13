@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-5">Data Pamong</h1>
            <span class="lead">Pengelolaan Data Pamong</span>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0">Ubah Data Pamong</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- @if ($errors->any())
                        @dd($errors->all())
                    @endif --}}
                    <form action="{{ route('datapamongupdate', $datapamong->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $datapamong->nip) }}">
                                    @error('nip')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $datapamong->nama) }}">
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="L" {{ old('jenis_kelamin', $datapamong->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $datapamong->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="golongan" class="form-label">Golongan</label>
                                    <input type="text" name="golongan" id="golongan" class="form-control @error('golongan') is-invalid @enderror" value="{{ old('golongan', $datapamong->golongan) }}">
                                    @error('golongan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $datapamong->jabatan) }}">
                                    @error('jabatan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="sekolah_id" class="form-label">Sekolah</label>
                                    <select name="sekolah_id" id="sekolah_id" class="form-control @error('sekolah_id') is-invalid @enderror">
                                        @foreach ($sekolahs as $sekolah)
                                            <option value="{{ $sekolah->id }}" {{ old('sekolah_id', $datapamong->sekolah_id ?? '') == $sekolah->id ? 'selected' : '' }}>{{ $sekolah->nama_sekolah }}</option>
                                        @endforeach
                                    </select>
                                    @error('sekolah_id')
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
            $('#sekolah_id').select2({
                placeholder: 'Cari Sekolah...',
                allowClear: true
            });
        });
    </script>
@endpush
