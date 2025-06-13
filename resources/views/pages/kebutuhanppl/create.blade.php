@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron bg-primary rounded p-4 text-white">
            <h1 class="display-4">Tambah Kuota PPL</h1>
            <p>Input kebutuhan kuota per jurusan untuk sekolah Anda.</p>
        </div>

        <div class="card mt-3 shadow-lg">
            <div class="card-header bg-white">
                <h5 class="mb-0">Form Kebutuhan PPL</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kuotappl.store') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($tahunAjaran as $tahun)
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>
                    <h6>Detail Jurusan dan Kuota</h6>

                    <div id="jurusan-container">
                        <div class="row jurusan-group mb-2">
                            <div class="col-md-5">
                                <select name="jurusan[]" class="form-control" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($jurusan as $j)
                                        <option value="{{ $j }}">{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="number" name="jumlah_mahasiswa[]" class="form-control"
                                    placeholder="Jumlah Mahasiswa" required min="1">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-jurusan">Hapus</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-jurusan" class="btn btn-outline-secondary mb-3">+ Tambah Jurusan</button>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('kuotappl') }}" class="btn btn-outline-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        let jurusanSemua = @json($jurusan);

        function getJurusanDipakai(tahun) {
            return fetch("{{ route('get-jurusan-tersisa') }}?tahun=" + tahun)
                .then(response => {
                    if (!response.ok) throw new Error("Network error");
                    return response.json();
                })
                .then(data => data.jurusanTersisa)
                .catch(err => {
                    console.error('Fetch error:', err);
                    return []; // fallback: kosong
                });
        }

        function buatPilihanJurusan(jurusanTersisa) {
            const select = document.createElement('select');
            select.name = "jurusan[]";
            select.classList.add('form-control');
            select.required = true;

            const defaultOption = document.createElement('option');
            defaultOption.value = "";
            defaultOption.textContent = "-- Pilih Jurusan --";
            select.appendChild(defaultOption);

            jurusanTersisa.forEach(j => {
                const opt = document.createElement('option');
                opt.value = j;
                opt.textContent = j;
                select.appendChild(opt);
            });

            return select;
        }

        document.getElementById('tahun_ajaran').addEventListener('change', async function() {
            const tahun = this.value;
            const jurusanTersisa = await getJurusanDipakai(tahun);

            // Ganti jurusan dropdown di grup pertama juga
            const select = buatPilihanJurusan(jurusanTersisa);
            const container = document.getElementById('jurusan-container');
            const firstGroup = container.querySelector('.jurusan-group');
            const selectWrapper = firstGroup.querySelector('.col-md-5');
            selectWrapper.innerHTML = '';
            selectWrapper.appendChild(select);

            // Bersihkan grup tambahan jika ada
            const allGroups = container.querySelectorAll('.jurusan-group');
            allGroups.forEach((group, index) => {
                if (index > 0) group.remove();
            });
        });

        document.getElementById('add-jurusan').addEventListener('click', async function() {
            const tahun = document.getElementById('tahun_ajaran').value;
            if (!tahun) {
                alert('Silakan pilih tahun ajaran terlebih dahulu.');
                return;
            }

            const jurusanTersisa = await getJurusanDipakai(tahun);
            const container = document.getElementById('jurusan-container');

            const template = container.querySelector('.jurusan-group');
            const group = template.cloneNode(true);

            // Ganti select jurusan dengan yang baru
            const selectWrapper = group.querySelector('.col-md-5');
            const newSelect = buatPilihanJurusan(jurusanTersisa);
            selectWrapper.innerHTML = '';
            selectWrapper.appendChild(newSelect);

            // Kosongkan input jumlah
            group.querySelector('input[name="jumlah_mahasiswa[]"]').value = '';

            container.appendChild(group);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-jurusan')) {
                const groups = document.querySelectorAll('.jurusan-group');
                if (groups.length > 1) {
                    e.target.closest('.jurusan-group').remove();
                }
            }
        });
    </script>
@endpush
