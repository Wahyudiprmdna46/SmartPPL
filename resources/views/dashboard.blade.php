@extends('layout.app') @section('content')
    <div class="jumbotron text-white"
        style="
        background: linear-gradient(135deg, #007bff, #0056b3);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    ">
        <h1 class="display-4 font-weight-bold">Selamat Datang!</h1>
        <p style="font-size: 18px; margin-top: 10px">
            Halo, <strong>{{ Auth::user()->name }}</strong> 👋 Selamat datang di
            <b>Smart-PPL</b>. Semoga harimu menyenangkan!
        </p>
    </div>

    {{-- Menyesuaikan tampilan berdasarkan role --}}
    <div class="row">
        @if (Auth::user()->role == 'admin')
            <!-- Total Mahasiswa -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary text-uppercase mb-1 text-xs">
                                    Total Mahasiswa
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    
                                    <a href="{{ route('datamahasiswa') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalMahasiswa }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tasks -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-info text-uppercase mb-1 text-xs">
                                    Tasks
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    <a href="{{ route('tasks.index') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalTasks }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total DPL -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-warning text-uppercase mb-1 text-xs">
                                    Total DPL
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    <a href="{{ route('datadpl') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalDpl }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Sekolah -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-success text-uppercase mb-1 text-xs">
                                    Total Sekolah
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    <a href="{{ route('datasekolah') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalSekolah }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-school fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pamong -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-danger text-uppercase mb-1 text-xs">
                                    Total Pamong
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    <a href="{{ route('datapamong') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalPamong }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAP SEKOLAH --}}
            <div class="row w-100">
                <div class="col-xl-12 col-lg-11">
                    <div class="card mb-4 shadow">
                        <div class="card-header d-flex align-items-center justify-content-between flex-row py-3">
                            <h6 class="font-weight-bold text-primary m-0">
                                Lokasi Sekolah
                            </h6>
                        </div>
                        <div class="card-body">
                            <h4 class="mb-4">Maps Sekolah</h4>

                            {{-- Search Bar --}}
                            <div class="d-flex mb-3">
                                <input list="namaSekolahList" type="text" id="searchInput" class="form-control me-2"
                                    placeholder="Cari nama sekolah..." />
                                <datalist id="namaSekolahList">
                                    @foreach ($sekolahs as $s)
                                        @if ($s->latitude && $s->longitude)
                                            <option value="{{ $s->nama_sekolah }}">
                                        @endif
                                    @endforeach
                                </datalist>
                                <button class="btn btn-primary" id="searchBtn">Cari</button>
                            </div>

                            <div id="map" style="height: 500px"></div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const map = L.map("map").setView([-2.5489, 118.0149], 5);

                    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        attribution: "© OpenStreetMap"
                    }).addTo(map);

                    const sekolahs = @json($sekolahs);
                    const markers = L.markerClusterGroup();
                    const titleMarkerMap = {};

                    // Custom icon
                    const icon = L.icon({
                        iconUrl: "https://cdn-icons-png.flaticon.com/512/447/447031.png",
                        iconSize: [32, 40],
                        iconAnchor: [16, 40],
                        popupAnchor: [0, -35],
                    });

                    sekolahs.forEach(sekolah => {
                        if (sekolah.latitude && sekolah.longitude) {
                            const lat = sekolah.latitude;
                            const lng = sekolah.longitude;
                            const nama = sekolah.nama_sekolah;
                            const alamat = sekolah.alamat ?? "Alamat tidak tersedia";
                            const jumlahMahasiswa = sekolah.data_mahasiswa_count ?? 0;

                            const imageUrl =
                                `https://maps.googleapis.com/maps/api/staticmap?center=${lat},${lng}&zoom=17&size=400x200&markers=color:red%7C${lat},${lng}&key=YOUR_GOOGLE_API_KEY`;

                            const popupContent = `
                    <div style="box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 8px; overflow: hidden; font-family: sans-serif;">
                        
                        <div style="padding: 10px;">
                            <h5 style="margin: 0 0 5px; color: #2c3e50;">${nama}</h5>
                            <p style="margin: 0 5px 8px 0; font-size: 14px; color: #555;">${alamat}</p>
                            <p style="margin: 0 0 10px; font-size: 13px; color: #2d3436;"><strong>Mahasiswa PPL:</strong> ${jumlahMahasiswa}</p>
                            <a href="https://www.google.com/maps/search/?api=1&query=${lat},${lng}" target="_blank"
                                style="display: inline-block; padding: 8px 12px; background-color: #1d72b8; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
                                Lihat di Google Maps
                            </a>
                        </div>
                    </div>
                `;

                            const marker = L.marker([lat, lng], {
                                title: nama,
                                icon: icon
                            }).bindPopup(popupContent);

                            markers.addLayer(marker);
                            titleMarkerMap[nama.toLowerCase()] = marker;
                        }
                    });

                    map.addLayer(markers);

                    const markerArray = Object.values(titleMarkerMap);
                    if (markerArray.length > 0) {
                        const group = new L.featureGroup(markerArray);
                        map.fitBounds(group.getBounds().pad(0.2));
                    }

                    // Search tombol
                    const searchBtn = document.getElementById("searchBtn");
                    const searchInput = document.getElementById("searchInput");

                    searchBtn.addEventListener("click", function() {
                        const query = searchInput.value.trim().toLowerCase();
                        let foundKey = null;
                        for (let key in titleMarkerMap) {
                            if (key.includes(query)) {
                                foundKey = key;
                                break;
                            }
                        }
                        if (foundKey) {
                            const marker = titleMarkerMap[foundKey];
                            markers.zoomToShowLayer(marker, function() {
                                // opsional, bisa dihilangkan kalau udah pas
                                marker.openPopup();
                            });

                        } else {
                            alert("Sekolah tidak ditemukan.");
                        }
                    });
                });
            </script>

            <!-- Tombol "Leaderboard" -->
            <div class="col-md-12 mt-3">
                <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                    <label class="btn btn-light flex-fill active">
                        <input type="radio" name="options" id="headerboard" autocomplete="off" checked />
                        Leaderboard Absensi Mahasiswa
                    </label>
                </div>
            </div>
            <div class="col-md-12 mb-3 mt-3">
                <div class="list-group">
                    @if ($leaderboard->isEmpty())
                        <div class="list-group-item text-muted py-4 text-center">
                            Belum ada mahasiswa yang melakukan absensi hari ini.
                        </div>
                    @else
                        @foreach ($leaderboard as $d)
                            @php $path = Storage::url('uploads/absensi/' . $d->foto_in); @endphp
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <img src="{{ url($path) }}" class="rounded"
                                    style="
                                        width: 50px;
                                        height: 50px;
                                        object-fit: cover;
                                        margin-right: 15px;
                                    " />

                                <div class="flex-grow-1">
                                    <strong>{{ $d->nama }}</strong>
                                    <br />
                                    <small class="text-muted">Sekolah: {{ $d->nama_sekolah }}</small>
                                    <br />
                                    <small class="text-muted">Tanggal Absen:
                                        {{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</small>
                                    <br />
                                    <small class="text-muted">Lokasi Masuk: {{ $d->lokasi_in }}</small>
                                    <br />
                                    <small class="text-muted">Lokasi Keluar:
                                        {{ $d->lokasi_out ?? 'Belum Absen Keluar' }}</small>
                                </div>

                                <div class="text-right">
                                    <span
                                        class="badge {{ $d->jam_in < '07:30' ? 'badge-success' : 'badge-danger' }} badge-pill">
                                        {{ $d->jam_in }}
                                    </span>
                                    <br />
                                    <span class="badge badge-secondary badge-pill">
                                        {{ $d->jam_out ?? 'Belum Absen Keluar' }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>

            </div>
        @elseif(Auth::user()->role == 'dpl')
            <!-- Total Mahasiswa -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary text-uppercase mb-1 text-xs">
                                    Total Mahasiswa
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    <a href="{{ route('datamahasiswa') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalMahasiswa }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Sekolah -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-success text-uppercase mb-1 text-xs">
                                    Total Sekolah
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    <a href="{{ route('datasekolah') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalSekolah }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-school fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pamong -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-danger text-uppercase mb-1 text-xs">
                                    Total Pamong
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    <a href="{{ route('datapamong') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalPamong }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAP SEKOLAH --}}
            <div class="row w-100">
                <div class="col-xl-12 col-lg-11">
                    <div class="card mb-4 shadow">
                        <div class="card-header d-flex align-items-center justify-content-between flex-row py-3">
                            <h6 class="font-weight-bold text-primary m-0">
                                Lokasi Sekolah
                            </h6>
                        </div>
                        <div class="card-body">
                            <h4 class="mb-4">Maps Sekolah</h4>

                            {{-- Search Bar --}}
                            <div class="d-flex mb-3">
                                <input list="namaSekolahList" type="text" id="searchInput" class="form-control me-2"
                                    placeholder="Cari nama sekolah..." />
                                <datalist id="namaSekolahList">
                                    @foreach ($sekolahs as $s)
                                        @if ($s->latitude && $s->longitude)
                                            <option value="{{ $s->nama_sekolah }}">
                                        @endif
                                    @endforeach
                                </datalist>
                                <button class="btn btn-primary" id="searchBtn">Cari</button>
                            </div>

                            <div id="map" style="height: 500px"></div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // inisialisasi peta
                    const map = L.map("map").setView([-2.5489, 118.0149], 5);

                    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        attribution: "© OpenStreetMap"
                    }).addTo(map);

                    // data sekolah dari controller
                    const sekolahs = @json($sekolahs);
                    // mengelompokkan maker yang berdekatan (cluster)
                    const markers = L.markerClusterGroup();
                    const titleMarkerMap = {};

                    // Custom icon
                    const icon = L.icon({
                        iconUrl: "https://cdn-icons-png.flaticon.com/512/447/447031.png",
                        iconSize: [32, 40],
                        iconAnchor: [16, 40],
                        popupAnchor: [0, -35],
                    });

                    // untuk menampilkan data sekolah berdasarkan longlang dengan looping
                    sekolahs.forEach(sekolah => {
                        if (sekolah.latitude && sekolah.longitude) {
                            const lat = sekolah.latitude;
                            const lng = sekolah.longitude;
                            const nama = sekolah.nama_sekolah;
                            const alamat = sekolah.alamat ?? "Alamat tidak tersedia";
                            const jumlahMahasiswa = sekolah.data_mahasiswa_count ?? 0;

                            const imageUrl =
                                `https://maps.googleapis.com/maps/api/staticmap?center=${lat},${lng}&zoom=17&size=400x200&markers=color:red%7C${lat},${lng}&key=YOUR_GOOGLE_API_KEY`;

                            // isi popup menampilkan data sekolah
                            const popupContent = `
                    <div style="box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 8px; overflow: hidden; font-family: sans-serif;">
                        
                        <div style="padding: 10px;">
                            <h5 style="margin: 0 0 5px; color: #2c3e50;">${nama}</h5>
                            <p style="margin: 0 5px 8px 0; font-size: 14px; color: #555;">${alamat}</p>
                            <p style="margin: 0 0 10px; font-size: 13px; color: #2d3436;"><strong>Mahasiswa PPL:</strong> ${jumlahMahasiswa}</p>
                            <a href="https://www.google.com/maps/search/?api=1&query=${lat},${lng}" target="_blank"
                                style="display: inline-block; padding: 8px 12px; background-color: #1d72b8; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
                                Lihat di Google Maps
                            </a>
                        </div>
                    </div>
                `;

                            // untuk memberikan maker dipeta
                            const marker = L.marker([lat, lng], {
                                title: nama,
                                icon: icon
                            }).bindPopup(popupContent);

                            markers.addLayer(marker);
                            titleMarkerMap[nama.toLowerCase()] = marker;
                        }
                    });

                    map.addLayer(markers);

                    const markerArray = Object.values(titleMarkerMap);
                    // menyesuaikan ukuran peta agar semua maker terlihat 
                    if (markerArray.length > 0) {
                        const group = new L.featureGroup(markerArray);
                        map.fitBounds(group.getBounds().pad(0.2));
                    }

                    // Search tombol
                    const searchBtn = document.getElementById("searchBtn");
                    const searchInput = document.getElementById("searchInput");

                    // fitur pencarian lokasi ppl
                    searchBtn.addEventListener("click", function() {
                        const query = searchInput.value.trim().toLowerCase();
                        let foundKey = null;
                        for (let key in titleMarkerMap) {
                            if (key.includes(query)) {
                                foundKey = key;
                                break;
                            }
                        }
                        if (foundKey) {
                            const marker = titleMarkerMap[foundKey];
                            markers.zoomToShowLayer(marker, function() {
                                // opsional, bisa dihilangkan kalau udah pas
                                marker.openPopup();
                            });

                        } else {
                            alert("Sekolah tidak ditemukan.");
                        }
                    });
                });
            </script>

            <!-- Tombol "Leaderboard" -->
            <div class="col-md-12 mt-3">
                <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                    <label class="btn btn-light flex-fill active">
                        <input type="radio" name="options" id="headerboard" autocomplete="off" checked />
                        Leaderboard Absensi Mahasiswa
                    </label>
                </div>
            </div>
            <div class="col-md-12 mb-3 mt-3">
                <div class="list-group">
                    @if ($leaderboard->isEmpty())
                        <div class="list-group-item text-muted py-4 text-center">
                            Belum ada mahasiswa yang melakukan absensi hari ini.
                        </div>
                    @else
                        @foreach ($leaderboard as $d)
                            @php $path = Storage::url('uploads/absensi/' . $d->foto_in); @endphp
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <img src="{{ url($path) }}" class="rounded"
                                    style="
                                        width: 50px;
                                        height: 50px;
                                        object-fit: cover;
                                        margin-right: 15px;
                                    " />

                                <div class="flex-grow-1">
                                    <strong>{{ $d->nama }}</strong>
                                    <br />
                                    <small class="text-muted">Sekolah: {{ $d->nama_sekolah }}</small>
                                    <br />
                                    <small class="text-muted">Tanggal Absen:
                                        {{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</small>
                                    <br />
                                    <small class="text-muted">Lokasi Masuk: {{ $d->lokasi_in }}</small>
                                    <br />
                                    <small class="text-muted">Lokasi Keluar:
                                        {{ $d->lokasi_out ?? 'Belum Absen Keluar' }}</small>
                                </div>

                                <div class="text-right">
                                    <span
                                        class="badge {{ $d->jam_in < '07:30' ? 'badge-success' : 'badge-danger' }} badge-pill">
                                        {{ $d->jam_in }}
                                    </span>
                                    <br />
                                    <span class="badge badge-secondary badge-pill">
                                        {{ $d->jam_out ?? 'Belum Absen Keluar' }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>

            </div>

            <!-- Absensi Mahasiswa -->
            {{--
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success h-100 py-2 shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div
                            class="font-weight-bold text-success text-uppercase mb-1 text-xs"
                        >
                            Absensi Mahasiswa
                        </div>
                        <div class="h5 font-weight-bold mb-0 text-gray-800">
                            {{ $totalAbsen }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    --}}
        @elseif(Auth::user()->role == 'mahasiswa')
            <div class="col-md-6">
                <a href="{{ route('absencreate') }}"
                    class="btn btn-success btn-lg btn-block d-flex align-items-center justify-content-center py-3">
                    @if ($presensihariini != null)
                        @php
                            $path = Storage::url('uploads/absensi/' . $presensihariini->foto_in);
                        @endphp
                        <img src="{{ url($path) }}" alt="Absensi Masuk" class="rounded"
                            style=" width: 50px; height: 50px; object-fit: cover; margin-right: 15px;" />
                    @else
                        <i class="fas fa-camera fa-2x mr-3"></i>
                    @endif
                    <div class="text-center">
                        <span class="d-block font-weight-bold">Absensi Masuk</span>
                        <small
                            class="text-light d-block">{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen' }}</small>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('absencreate') }}"
                    class="btn btn-danger btn-lg btn-block d-flex align-items-center justify-content-center py-3">
                    @if ($presensihariini != null && $presensihariini->jam_out != null)
                        @php $path = Storage::url('uploads/absensi/' . $presensihariini->foto_out); @endphp
                        <img src="{{ url($path) }}" alt="Absensi Masuk" class="rounded"
                            style="
                    width: 50px;
                    height: 50px;
                    object-fit: cover;
                    margin-right: 15px;
                " />
                    @else
                        <i class="fas fa-camera fa-2x mr-3"></i>
                    @endif
                    <div class="text-center">
                        <span class="d-block font-weight-bold">Absensi Pulang</span>
                        <small
                            class="text-light d-block">{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen' }}</small>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mt-3">
                <a href="{{ route('tasks.index') }}" class="btn btn-info btn-lg btn-block text-center">
                    <i class="fas fa-tasks"></i> Tasks
                </a>
            </div>

            <!-- Tambahkan row agar menu-menus sejajar -->
            <div class="row justify-content-center w-100 mt-5 gap-3">
                <div class="col-12 text-center">
                    <h3 class="text-dark">
                        Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun
                        {{ $tahunini }}
                    </h3>
                </div>
                <div class="col-auto">
                    <div class="d-flex flex-column align-items-center justify-content-center bg-light rounded p-3 shadow-sm"
                        style="width: 90px">
                        <span class="badge bg-danger text-warning"
                            style="
                        position: absolute;
                        top: 12px;
                        right: 33px;
                        font-size: 0.6rem;
                        z-index: 999;
                    ">{{ $rekappresensi->jmlhadir }}</span>
                        <ion-icon name="accessibility-outline" class="text-primary" style="font-size: 30px"></ion-icon>
                        <span class="text-dark mt-2" style="font-size: 16px">Hadir</span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex flex-column align-items-center justify-content-center bg-light rounded p-3 shadow-sm"
                        style="width: 90px">
                        <span class="badge bg-danger text-warning"
                            style="
                        position: absolute;
                        top: 12px;
                        right: 33px;
                        font-size: 0.6rem;
                        z-index: 999;
                    ">{{ $rekappresensi->jmlterlambat }}</span>
                        <ion-icon name="alarm-outline" class="text-danger" style="font-size: 30px"></ion-icon>
                        <span class="text-dark mt-2" style="font-size: 16px">Telat</span>
                    </div>
                </div>
            </div>

            <!-- Tombol "Bulan Ini" -->
            <div class="col-md-12 mt-3">
                <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                    <label class="btn btn-light flex-fill active">
                        <input type="radio" name="options" id="bulanIni" autocomplete="off" checked />
                        Bulan Ini
                    </label>
                </div>
            </div>

            <!-- Tambahan Kolom Baru -->
            <div class="col-md-12 mb-3 mt-3">
                <div class="list-group">
                    @foreach ($historibulanini as $d)
                        @php $path = Storage::url('uploads/absensi/' . $d->foto_in); @endphp
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <img src="{{ url($path) }}" class="rounded"
                                style="
                        width: 50px;
                        height: 50px;
                        object-fit: cover;
                        margin-right: 15px;
                    " />
                            <span class="flex-grow-1">{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</span>
                            <span class="badge badge-success badge-pill mr-2">{{ $d->jam_in }}</span>
                            <span
                                class="badge badge-danger badge-pill">{{ $presensihariini != null && $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Tombol "Leaderboard" -->
            <div class="col-md-12 mt-3">
                <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                    <label class="btn btn-light flex-fill active">
                        <input type="radio" name="options" id="headerboard" autocomplete="off" checked />
                        Leaderboard Absensi Mahasiswa
                    </label>
                </div>
            </div>
            <div class="col-md-12 mb-3 mt-3">
                <div class="list-group">
                    @foreach ($leaderboard as $d)
                        @php $path = Storage::url('uploads/absensi/' . $d->foto_in); @endphp
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <img src="{{ url($path) }}" class="rounded"
                                style="
                        width: 50px;
                        height: 50px;
                        object-fit: cover;
                        margin-right: 15px;
                    " />

                            <div class="flex-grow-1">
                                <strong>{{ $d->nama }}</strong>
                                <br />
                                <small class="text-muted">Sekolah: {{ $d->nama_sekolah }}</small>
                                <br />
                                <small class="text-muted">Tanggal Absen:
                                    {{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</small>
                                <br />
                                <small class="text-muted">Lokasi Masuk: {{ $d->lokasi_in }}</small>
                                <br />
                                <small class="text-muted">Lokasi Keluar:
                                    {{ $d->lokasi_out ?? 'Belum Absen Keluar' }}</small>
                            </div>

                            <div class="text-right">
                                <span
                                    class="badge {{ $d->jam_in < '07:30' ? 'badge-success' : 'badge-danger' }} badge-pill">
                                    {{ $d->jam_in }}
                                </span>
                                <br />
                                <span class="badge badge-secondary badge-pill">
                                    {{ $d->jam_out ?? 'Belum Absen Keluar' }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @elseif(Auth::user()->role == 'sekolah')
            <!-- Total Mahasiswa -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary text-uppercase mb-1 text-xs">
                                    Total Mahasiswa
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    
                                    <a href="{{ route('datamahasiswa') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalMahasiswa }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Pamong -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-danger text-uppercase mb-1 text-xs">
                                    Total Pamong
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    <a href="{{ route('datapamong') }}" class="text-gray-800 text-decoration-none">
                                        {{ $totalPamong }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol "Leaderboard" -->
            <div class="col-md-12 mt-3">
                <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                    <label class="btn btn-light flex-fill active">
                        <input type="radio" name="options" id="headerboard" autocomplete="off" checked />
                        Leaderboard Absensi Mahasiswa
                    </label>
                </div>
            </div>
            <div class="col-md-12 mb-3 mt-3">
                <div class="list-group">
                    @if ($leaderboard->isEmpty())
                        <div class="list-group-item text-muted py-4 text-center">
                            Belum ada mahasiswa yang melakukan absensi hari ini.
                        </div>
                    @else
                        @foreach ($leaderboard as $d)
                            @php $path = Storage::url('uploads/absensi/' . $d->foto_in); @endphp
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <img src="{{ url($path) }}" class="rounded"
                                    style="
                                        width: 50px;
                                        height: 50px;
                                        object-fit: cover;
                                        margin-right: 15px;
                                    " />

                                <div class="flex-grow-1">
                                    <strong>{{ $d->nama }}</strong>
                                    <br />
                                    <small class="text-muted">Sekolah: {{ $d->nama_sekolah }}</small>
                                    <br />
                                    <small class="text-muted">Tanggal Absen:
                                        {{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</small>
                                    <br />
                                    <small class="text-muted">Lokasi Masuk: {{ $d->lokasi_in }}</small>
                                    <br />
                                    <small class="text-muted">Lokasi Keluar:
                                        {{ $d->lokasi_out ?? 'Belum Absen Keluar' }}</small>
                                </div>

                                <div class="text-right">
                                    <span
                                        class="badge {{ $d->jam_in < '07:30' ? 'badge-success' : 'badge-danger' }} badge-pill">
                                        {{ $d->jam_in }}
                                    </span>
                                    <br />
                                    <span class="badge badge-secondary badge-pill">
                                        {{ $d->jam_out ?? 'Belum Absen Keluar' }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>

            </div>
        @elseif(Auth::user()->role == 'pamong')
            <!-- Total Mahasiswa -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary text-uppercase mb-1 text-xs">
                                    Total Mahasiswa
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    {{ $totalMahasiswa }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tasks -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-info text-uppercase mb-1 text-xs">
                                    Tasks
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">
                                    {{ $totalTasks }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol "Leaderboard" -->
            <div class="col-md-12 mt-3">
                <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                    <label class="btn btn-light flex-fill active">
                        <input type="radio" name="options" id="headerboard" autocomplete="off" checked />
                        Leaderboard Absensi Mahasiswa
                    </label>
                </div>
            </div>
            <div class="col-md-12 mb-3 mt-3">
                <div class="list-group">
                    @if ($leaderboard->isEmpty())
                        <div class="list-group-item text-muted py-4 text-center">
                            Belum ada mahasiswa yang melakukan absensi hari ini.
                        </div>
                    @else
                        @foreach ($leaderboard as $d)
                            @php $path = Storage::url('uploads/absensi/' . $d->foto_in); @endphp
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <img src="{{ url($path) }}" class="rounded"
                                    style="
                                        width: 50px;
                                        height: 50px;
                                        object-fit: cover;
                                        margin-right: 15px;
                                    " />

                                <div class="flex-grow-1">
                                    <strong>{{ $d->nama }}</strong>
                                    <br />
                                    <small class="text-muted">Sekolah: {{ $d->nama_sekolah }}</small>
                                    <br />
                                    <small class="text-muted">Tanggal Absen:
                                        {{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</small>
                                    <br />
                                    <small class="text-muted">Lokasi Masuk: {{ $d->lokasi_in }}</small>
                                    <br />
                                    <small class="text-muted">Lokasi Keluar:
                                        {{ $d->lokasi_out ?? 'Belum Absen Keluar' }}</small>
                                </div>

                                <div class="text-right">
                                    <span
                                        class="badge {{ $d->jam_in < '07:30' ? 'badge-success' : 'badge-danger' }} badge-pill">
                                        {{ $d->jam_in }}
                                    </span>
                                    <br />
                                    <span class="badge badge-secondary badge-pill">
                                        {{ $d->jam_out ?? 'Belum Absen Keluar' }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>

            </div>
        @endif
    </div>
@endsection
