@extends('layout.app')
@section('content')
    <div class="jumbotron mt-3">
        <h1 class="display-4">Data Penilaian Mahasiswa</h1>
        <p>Pengelolaan penilaian mahasiswa ppl dari DPL</p>
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
                    @if ($canUpload)
                        <button type="button" class="btn btn-danger mr-2" data-bs-toggle="modal"
                            data-bs-target="#nilaiModal">
                            <i class="fas fa-plus"></i> Upload Nilai
                        </button>
                    @endif
                    @if ($canExport)
                        <a href="{{ route('penilaian-dpl.export') }}" class="btn btn-success">
                            <i class="fas fa-file-download"></i> Export Data
                        </a>
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
                                    <th>Nama Mahasiswa</th>
                                    <th>Nama DPL</th>
                                    <th>Persiapan Mengajar</th>
                                    <th>Praktek Mengajar</th>
                                    <th>Laporan PPL</th>
                                    <th>Nilai Akhir</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penilaians as $index => $item)
                                    <tr style="border: 2px solid #2c3e50; background-color: white;">
                                        <td class="text-center">
                                            {{ $index + $penilaians->firstItem() }}</td>
                                        <td class="text-center">
                                            {{ $item->Mahasiswa->nim }}</td>
                                        <td class="text-center">
                                            {{ $item->Mahasiswa->nama }}</td>
                                        <td class="text-center">
                                            {{ $item->dpl?->nama ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $item->persiapan_mengajar ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $item->praktek_mengajar ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $item->laporan_ppl ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $item->nilai_akhir ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $item->catatan ?? '-' }}</td>
                                        <td style="white-space: nowrap;">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if ($canEdit)
                                                    <button class="btn btn-sm btn-warning btn-edit mr-2"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-id="{{ $item->id }}"
                                                        data-mahasiswa="{{ $item->Mahasiswa->nama }}"
                                                        data-persiapan_mengajar="{{ $item->persiapan_mengajar }}"
                                                        data-praktek_mengajar="{{ $item->praktek_mengajar }}"
                                                        data-laporan_ppl="{{ $item->laporan_ppl }}"
                                                        data-catatan="{{ $item->catatan }}">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                @endif

                                                @if ($canDelete)
                                                    <form action="{{ route('penilaiandpl.destroy', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger mr-2">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($canExport)
                                                    <a href="{{ route('penilaiandplpdf', $item->id) }}"
                                                        class="btn btn-sm btn-success mr-2">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a href="{{ route('penilaianpdfdplshow', $item->id) }}"
                                                        class="btn btn-sm btn-primary" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data penilaian.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $penilaians->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Tambah Penilaian --}}
        @include('pages.kelolamahasiswa.penilaiandpl._modal-create', ['mahasiswas' => $mahasiswas])

        {{-- Modal Edit Penilaian --}}
        @include('pages.kelolamahasiswa.penilaiandpl._modal-edit')
    @endsection

    @push('myscript')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const persiapanInput = document.querySelector('input[name="persiapan_mengajar"]');
                const praktekInput = document.querySelector('input[name="praktek_mengajar"]');
                const laporanInput = document.querySelector('input[name="laporan_ppl"]');
                const akhirPreview = document.getElementById('nilaiAkhirPreview');

                function hitungNilaiAkhir() {
                    const persiapan = parseFloat(persiapanInput.value) || 0;
                    const praktek = parseFloat(praktekInput.value) || 0;
                    const laporan = parseFloat(laporanInput.value) || 0;
                    const nilaiAkhir = ((persiapan * 2) + (praktek * 5) + (laporan * 3)).toFixed(2);
                    akhirPreview.value = nilaiAkhir;
                }

                // Event listener modal CREATE
                persiapanInput?.addEventListener('input', hitungNilaiAkhir);
                praktekInput?.addEventListener('input', hitungNilaiAkhir);
                laporanInput?.addEventListener('input', hitungNilaiAkhir);

                // =======================
                // Tambahkan untuk modal EDIT
                // =======================
                const persiapanEdit = document.getElementById('editNilaiPersiapan');
                const praktekEdit = document.getElementById('editNilaiPraktek');
                const laporanEdit = document.getElementById('editNilaiLaporan');
                const akhirEdit = document.getElementById('editNilaiAkhir');

                function hitungNilaiAkhirEdit() {
                    const s = parseFloat(persiapanEdit.value) || 0;
                    const p = parseFloat(praktekEdit.value) || 0;
                    const l = parseFloat(laporanEdit.value) || 0;
                    akhirEdit.value = ((s * 2) + (p * 5) + (l * 3)).toFixed(2);
                }

                persiapanEdit?.addEventListener('input', hitungNilaiAkhirEdit);
                praktekEdit?.addEventListener('input', hitungNilaiAkhirEdit);
                laporanEdit?.addEventListener('input', hitungNilaiAkhirEdit);

                // =======================
                // Pas buka modal edit
                // =======================
                const editButtons = document.querySelectorAll('.btn-edit');
                const formEdit = document.getElementById('editForm');

                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const nama = this.getAttribute('data-mahasiswa') ?? '';
                        const persiapan = this.getAttribute('data-persiapan_mengajar') ?? '';
                        const praktek = this.getAttribute('data-praktek_mengajar') ?? '';
                        const laporan = this.getAttribute('data-laporan_ppl') ?? '';
                        const catatan = this.getAttribute('data-catatan') ?? '';

                        document.getElementById('editNamaMahasiswa').value = nama;
                        persiapanEdit.value = persiapan;
                        praktekEdit.value = praktek;
                        laporanEdit.value = laporan;
                        document.getElementById('editCatatan').value = catatan;

                        // Hitung ulang nilai akhir saat modal dibuka
                        hitungNilaiAkhirEdit();

                        // Set action ke form
                        formEdit.action = '{{ route('penilaiandpl.update', ':id') }}'.replace(':id',
                            id);
                    });
                });
            });
        </script>
    @endpush
