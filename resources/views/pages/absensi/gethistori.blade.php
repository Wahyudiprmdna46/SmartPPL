@if ($histori->isEmpty())
    <div class="alert alert-light border-warning border">
        <p>Data Belum Ada</p>
    </div>
@else
    <div class="mb-3 text-right d-flex justify-content-end gap-2">
        <form action="{{ route('showpdf') }}" method="POST" target="_blank" class="mr-2">
            @csrf
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-eye"></i> Show PDF
            </button>
        </form>

        <form action="{{ route('downloadpdf') }}" method="POST" target="_blank">
            @csrf
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Download PDF
            </button>
        </form>
    </div>

    @foreach ($histori as $d)
        <div class="col-md-12 mb-3 mt-3">
            <div class="list-group">
                @php
                    $path = Storage::url('uploads/absensi/' . $d->foto_in);
                @endphp
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <img src="{{ url($path) }}" class="rounded"
                        style="width: 50px; height: 50px; object-fit: cover; margin-right: 15px;">

                    <div class="flex-grow-1">
                        <strong>{{ $d->nama }}</strong> - <span class="text-primary">{{ $d->nama_sekolah }}</span>
                        <br>
                        <small class="text-muted">DPL: {{ $d->nama_dpl }}</small>
                        <br>
                        <small class="text-muted">Tanggal Absen:
                            {{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</small>
                        <br>
                        <small class="text-muted">Lokasi Masuk: {{ $d->lokasi_in ?? 'Belum Absen Masuk' }}</small>
                        <br>
                        <small class="text-muted">Lokasi Keluar: {{ $d->lokasi_out ?? 'Belum Absen Pulang' }}</small>
                    </div>

                    <span class="badge {{ $d->jam_in < '07:30' ? 'badge-success' : 'badge-danger' }} badge-pill mr-2">
                        {{ $d->jam_in }}
                    </span>
                    <span class="badge badge-primary">
                        {{ $d->jam_out ?? '' }}
                    </span>
                </a>
            </div>
        </div>
    @endforeach

@endif
