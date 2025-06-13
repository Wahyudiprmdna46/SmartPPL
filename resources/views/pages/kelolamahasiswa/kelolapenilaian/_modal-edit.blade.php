<!-- Modal Edit Penilaian (Statis, diisi via JS) -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Penilaian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="editNamaMahasiswa" readonly>
                    </div>

                    <div class="form-group mt-2">
                        <label>Persiapan Mengajar</label>
                        <input type="number" step="0.01" name="persiapan_mengajar" class="form-control" id="editNilaiPersiapan">
                    </div>

                    <div class="form-group mt-2">
                        <label>Praktek Mengajar</label>
                        <input type="number" step="0.01" name="praktek_mengajar" class="form-control" id="editNilaiPraktek">
                    </div>

                    <div class="form-group mt-2">
                        <label>Laporan PPL</label>
                        <input type="number" step="0.01" name="laporan_ppl" class="form-control" id="editNilaiLaporan">
                    </div>

                    <div class="form-group mt-2">
                        <label>Nilai Akhir</label>
                        <input type="number" step="0.01" name="nilai_akhir" class="form-control" id="editNilaiAkhir" readonly>
                    </div>

                    <div class="form-group mt-2">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" id="editCatatan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>