@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-5">Data Account Users</h1>
            <span class="lead">Pengelolaan Account Users</span>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0">Edit Account</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- @if ($errors->any())
                        @dd($errors->all())
                    @endif --}}
                    <form action="{{ route('accountupdate', $dataaccounts->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role"
                                        class="form-control @error('role') is-invalid @enderror">
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin"
                                            {{ old('role', $dataaccounts->role) == 'admin' ? 'selected' : '' }}>
                                            Administrator</option>
                                        <option value="dpl"
                                            {{ old('role', $dataaccounts->role) == 'dpl' ? 'selected' : '' }}>Dosen
                                            Pembimbing Lapangan</option>
                                        <option value="mahasiswa"
                                            {{ old('role', $dataaccounts->role) == 'mahasiswa' ? 'selected' : '' }}>
                                            Mahasiswa</option>
                                        <option value="sekolah"
                                            {{ old('role', $dataaccounts->role) == 'sekolah' ? 'selected' : '' }}>Sekolah
                                        </option>
                                        <option value="pamong"
                                            {{ old('role', $dataaccounts->role) == 'pamong' ? 'selected' : '' }}>Pamong
                                        </option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name"
                                        class="form-label @error('name') is-invalid @enderror">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $dataaccounts->name) }}">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email"
                                        class="form-label @error('email') is-invalid @enderror">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email', $dataaccounts->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nim" class="form-label @error('nim') is-invalid @enderror">NIM</label>
                                    <input type="text" name="nim" id="nim" class="form-control"
                                        value="{{ old('nim', $dataaccounts->nim) }}">
                                    @error('nim')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nip" class="form-label @error('nip') is-invalid @enderror">NIP</label>
                                    <input type="text" name="nip" id="nip" class="form-control"
                                        value="{{ old('nip', $dataaccounts->nip) }}">
                                    @error('nip')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nik" class="form-label @error('nik') is-invalid @enderror">NIK</label>
                                    <input type="text" name="nik" id="nik" class="form-control"
                                        value="{{ old('nik', $dataaccounts->nik) }}">
                                    @error('nik')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="npsn"
                                        class="form-label @error('npsn') is-invalid @enderror">NPSN</label>
                                    <input type="text" name="npsn" id="npsn" class="form-control"
                                        value="{{ old('npsn', $dataaccounts->npsn) }}">
                                    @error('npsn')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password"
                                        class="form-label @error('password') is-invalid @enderror">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Kosongkan jika tidak ingin mengubah">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword()">👁</button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.account') }}"
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
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
@endpush
