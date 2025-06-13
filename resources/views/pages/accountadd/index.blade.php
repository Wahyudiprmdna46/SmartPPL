@extends('layout.app') {{-- Ganti dengan layout yang kamu pakai --}}

@section('content')
    <div class="container mt-4">
        <h3>Import Data Admin dari Excel</h3>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('duplicate_error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Data duplikat:</strong>
                <ul>
                    @foreach (session('duplicate_error') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Upload Form --}}
        <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Pilih File Excel (.xlsx)</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
@endsection
