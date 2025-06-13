    <!-- Modal -->
    <div class="modal fade" id="nilaiModal" tabindex="-1" aria-labelledby="nilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('penilaian.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Penilaian</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="mahasiswa_id">Mahasiswa</label>
                                <select name="mahasiswa_id" class="form-control" required>
                                    <option value="">-- Pilih Mahasiswa --</option>
                                    @foreach ($mahasiswas as $mhs)
                                        <option value="{{ $mhs->id }}">{{ $mhs->nim }} - {{ $mhs->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Persiapan Mengajar</label>
                                <input type="number" step="0.01" name="persiapan_mengajar" class="form-control"
                                    value="{{ old('persiapan_mengajar') }}">
                                @error('persiapan_mengajar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Praktek Mengajar</label>
                                <input type="number" step="0.01" name="praktek_mengajar" class="form-control"
                                    value="{{ old('praktek_mengajar') }}">
                                @error('praktek_mengajar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Laporan PPL</label>
                                <input type="number" step="0.01" name="laporan_ppl" class="form-control"
                                    value="{{ old('laporan_ppl') }}">
                                @error('laporan_ppl')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Nilai Akhir (otomatis)</label>
                                <input type="text" class="form-control" id="nilaiAkhirPreview" readonly>
                            </div>

                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>