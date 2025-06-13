@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-5">Data Sekolah</h1>
            <span class="lead">Pengelolaan Data Sekolah</span>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0">Tambah Data Sekolah</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- @if ($errors->any())
                        @dd($errors->all())
                    @endif --}}
                    <form action="{{ route('datasekolahstore') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="npsn" class="form-label">NPSN</label>
                                    <input type="text" name="npsn" id="npsn"
                                        class="form-control @error('npsn') is-invalid @enderror"
                                        value="{{ old('npsn') }}">
                                    @error('npsn')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                                    <input type="text" name="nama_sekolah" id="nama_sekolah"
                                        class="form-control @error('nama_sekolah') is-invalid @enderror"
                                        value="{{ old('nama_sekolah') }}">
                                    @error('nama_sekolah')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="dpl_id" class="form-label">dpl</label>
                                    <select name="dpl_id" id="dpl_id"
                                        class="form-control @error('dpl_id') is-invalid @enderror">
                                        <option value="">-- Pilih DPL --</option>
                                        @foreach ($dpls as $dpl)
                                            <option value="{{ $dpl->id }}">{{ $dpl->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('dpl_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" name="alamat" id="alamat"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        value="{{ old('alamat') }}">
                                    @error('alamat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="kota" class="form-label">Kota</label>
                                    <input type="text" name="kota" id="kota"
                                        class="form-control @error('kota') is-invalid @enderror"
                                        value="{{ old('kota') }}">
                                    @error('kota')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" name="provinsi" id="provinsi"
                                        class="form-control @error('provinsi') is-invalid @enderror"
                                        value="{{ old('provinsi') }}">
                                    @error('provinsi')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tambahan koordinat -->
                                <div class="form-group">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" name="latitude" id="latitude"
                                        class="form-control @error('latitude') is-invalid @enderror"
                                        placeholder="Contoh: -6.914744"
                                        value="{{ old('latitude') }}">
                                    @error('latitude')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" name="longitude" id="longitude"
                                        class="form-control @error('longitude') is-invalid @enderror"
                                        placeholder="Contoh: 107.609810"
                                        value="{{ old('longitude') }}">
                                    @error('longitude')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('datasekolah') }}"
                                            class="btn btn-sm btn-outline-secondary mr-2">Batal</a>
                                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
            $('#dpl_id').select2({
                placeholder: 'Cari DPL...',
                allowClear: true
            });
        });
    </script>
@endpush
