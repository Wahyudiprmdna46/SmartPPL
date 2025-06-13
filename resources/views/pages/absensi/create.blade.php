@extends('layout.app')

@section('content')
    {{-- <div class="jumbotron mt-3">
        <h1 class="display-4">Data Only Mahasiswa</h1>
        <p>Pengelolaan absensi mahasiswa ppl</p>
    </div> --}}
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1 class="card-title">Presensi</h1>
                    <p class="card-text">Klik tombol di bawah untuk melakukan absensi menggunakan kamera.</p>
                    <input type="hidden" id="lokasi">

                    <!-- Webcam Preview -->
                    <div class="webcam-container">
                        <div class="webcam-capture"></div>
                    </div>
                    <!-- Tombol Absen -->
                    @if ($cek > 0)
                        <button id="takeabsen" class="btn btn-danger btn-block mt-2">
                            <i class="fas fa-camera"></i> Absen pulang
                        </button>
                    @else
                        <button id="takeabsen" class="btn btn-success btn-block mt-2">
                            <i class="fas fa-camera"></i> Absen Masuk
                        </button>
                    @endif
                </div>
                <!-- Lokasi & Peta -->
                <div class="card-footer bg-white p-3">
                    <h5 class="text-center">Lokasi Anda</h5>
                    <div id="map"></div>
                </div>
                <audio id="notifikasi_in">
                    <source src="{{ asset('assets/sound/notifikasi_in.mp3') }}" type="audio/mpeg">
                </audio>
                <audio id="notifikasi_out">
                    <source src="{{ asset('assets/sound/notifikasi_out.mp3') }}" type="audio/mpeg">
                </audio>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        var notifikasi_in = document.getElementById('notifikasi_in');
        var notifikasi_out = document.getElementById('notifikasi_out');
        Webcam.set({
            height: 320,
            width: 240,
            image_format: 'jpeg',
            jpeg_quality: 80
        });

        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            // // mengubah manual lokasi (jl. kis mangunsarkoro)
            // var circle = L.circle([-0.9336213392919279, 100.36507051835851], {
            //     color: 'red',
            //     fillColor: '#f03',
            //     fillOpacity: 0.5,
            //     radius: 5
            // }).addTo(map);
        }

        function errorCallback() {

        }

        $("#takeabsen").click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;
            });
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: 'POST',
                url: '{{ route('absenstore') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|");
                    if (status[0] == "success") {
                        if (status[2] == "in") {
                            notifikasi_in.play();
                        } else {
                            notifikasi_out.play();
                        }
                        Swal.fire({
                            title: 'Berhasil!',
                            text: status[1],
                            icon: 'success',
                        })
                        setTimeout(function() {
                            window.location.href =
                                "{{ route('dashboard') }}"; // Redirect menggunakan nama route
                        }, 3000);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error',
                        })
                    }
                }
            });

        });
    </script>
@endpush
