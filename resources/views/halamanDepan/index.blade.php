<!DOCTYPE html>
<html lang="en">

<head>
    <title>SMART-PPL</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/png" href="{{ asset('halaman_auth/images/icons/favicon.ico') }}" />
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('halaman_depan/assets/favicon.ico" /') }}">
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />


    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('halaman_depan/css/styles.css') }}" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">

            <!-- Brand with GIF -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="#page-top">
                <img src="{{ asset('storage/home/lv_0_20250305180903-ezgif.com-video-to-gif-converter.gif') }}"
                    alt="Logo UIN" style="height: 40px; width: auto;" />
                <span>SMART-PPL</span>
            </a>

            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary rounded text-white" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>

            <div class="navbar-collapse collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    {{-- <li class="nav-item mx-lg-1 mx-0"><a class="nav-link px-lg-3 rounded px-0 py-3"
                            href="#about">About</a></li> --}}
                    <li class="nav-item mx-lg-1 mx-0"><a class="nav-link px-lg-3 rounded px-0 py-3"
                            href="{{ route('admin.login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead -->
    <header class="masthead text-center text-white"
        style="background: url('{{ asset('storage/home/IMG-20250320-WA0011.jpg') }}') center/cover no-repeat; min-height: 100vh;">
        <div class="d-flex justify-content-center align-items-center container"
            style="min-height: 100vh; flex-direction: column;">

            <!-- Masthead Heading -->
            <h1 class="masthead-heading text-uppercase mb-3">UIN Bukittinggi</h1>

            <!-- Icon Divider -->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>

            <!-- Masthead Subheading -->
            <p class="masthead-subheading font-weight-light mb-0">Sjech M. Djamil Djambek - Bukittinggi</p>
        </div>
    </header>

    <!-- About Section -->
    <section class="page-section mb-0 text-white" id="about" style="background-color: #1f4037;">
        <div class="container">
            <!-- About Section Heading -->
            <h2 class="page-section-heading text-uppercase text-center">About</h2>

            <!-- Icon Divider -->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>

            <!-- About Section Content -->
            <div class="row">
                <div class="col-lg-4 ms-auto">
                    <p class="lead">Website ini merupakan platform Smart-PPL milik Fakultas Tarbiyah dan Ilmu Keguruan
                        UIN Sjech M. Djamil Djambek Bukittinggi yang dirancang untuk memanajemen seluruh kegiatan
                        Praktik Pengalaman Lapangan (PPL) mahasiswa.</p>
                </div>
                <div class="col-lg-4 me-auto">
                    <p class="lead">Desain berbasis Bootstrap ini mendukung pengelolaan administrasi, tugas,
                        penilaian, dan presensi mahasiswa secara terintegrasi selama pelaksanaan PPL.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="footer text-center">
        <div class="container">
            <div class="row">
                <!-- Footer Location-->
                <div class="col-lg-4 mb-lg-0 mb-5">
                    <h4 class="text-uppercase mb-4">Location</h4>
                    <p class="lead mb-0">
                        UIN Sjech M. Djamil Djambek Bukittinggi<br />
                        Jl. Gurun Aur Kubang Putih, Kec. Banuhampu, Kab. Agam, Sumatera Barat
                    </p>
                </div>
                <!-- Footer Social Icons-->
                <div class="col-lg-4 mb-lg-0 mb-5">
                    <h4 class="text-uppercase mb-4">Pengembang Web</h4>
                    <a class="btn btn-outline-light btn-social mx-1"
                        href="https://r.search.yahoo.com/_ylt=Awrx.qZAAxxoJgMA8KvLQwx.;_ylu=Y29sbwNzZzMEcG9zAzEEdnRpZAMEc2VjA3Ny/RV=2/RE=1747875904/RO=10/RU=https%3a%2f%2fwww.instagram.com%2fwahyudiprmdna%2f/RK=2/RS=IJZdm.CgBYNRRQ.7M85aS18rk68-"
                        target="_blank" rel="noopener">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="btn btn-outline-light btn-social mx-1"
                        href="https://id.linkedin.com/in/wahyudi-primadana-1aab19211?trk=people-guest_people_search-card"
                        target="_blank" rel="noopener">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
                <!-- Footer About Text-->
                <div class="col-lg-4">
                    <h4 class="text-uppercase mb-4">Teknologi & Pengembangan</h4>
                    <p class="lead mb-0">
                        Platform ini dikembangkan menggunakan framework Laravel dan Bootstrap untuk mendukung
                        transformasi digital dalam pengelolaan PPL secara efisien dan terintegrasi di lingkungan
                        Fakultas Tarbiyah dan Ilmu Keguruan UIN SMDD Bukittinggi.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>&copy; 2025 Wahyudiprimadana | All Rights Reserved</small></div>
    </div>
    <!-- Portfolio Modals-->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" aria-labelledby="portfolioModal1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body pb-5 text-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Log Cabin</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <img class="img-fluid mb-5 rounded"
                                    src="{{ asset('halaman_depan/assets/img/portfolio/cabin.png') }}"
                                    alt="..." />
                                <!-- Portfolio Modal - Text-->
                                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia
                                    neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore
                                    quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur
                                    itaque. Nam.</p>
                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Close Window
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal 2-->
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" aria-labelledby="portfolioModal2"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body pb-5 text-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Tasty Cake</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <img class="img-fluid mb-5 rounded"
                                    src="{{ asset('halaman_depan/assets/img/portfolio/cake.png') }}" alt="..." />
                                <!-- Portfolio Modal - Text-->
                                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia
                                    neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore
                                    quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur
                                    itaque. Nam.</p>
                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Close Window
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal 3-->
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" aria-labelledby="portfolioModal3"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body pb-5 text-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Circus Tent</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <img class="img-fluid mb-5 rounded"
                                    src="{{ asset('halaman_depan/assets/img/portfolio/circus.png') }}"
                                    alt="..." />
                                <!-- Portfolio Modal - Text-->
                                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia
                                    neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore
                                    quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur
                                    itaque. Nam.</p>
                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Close Window
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal 4-->
    <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" aria-labelledby="portfolioModal4"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body pb-5 text-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Controller</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <img class="img-fluid mb-5 rounded"
                                    src="{{ asset('halaman_depan/assets/img/portfolio/game.png') }}" alt="..." />
                                <!-- Portfolio Modal - Text-->
                                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia
                                    neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore
                                    quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur
                                    itaque. Nam.</p>
                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Close Window
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal 5-->
    <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" aria-labelledby="portfolioModal5"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body pb-5 text-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Locked Safe</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <img class="img-fluid mb-5 rounded"
                                    src="{{ asset('halaman_depan/assets/img/portfolio/safe.png') }}" alt="..." />
                                <!-- Portfolio Modal - Text-->
                                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia
                                    neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore
                                    quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur
                                    itaque. Nam.</p>
                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Close Window
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal 6-->
    <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" aria-labelledby="portfolioModal6"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body pb-5 text-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Submarine</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <img class="img-fluid mb-5 rounded"
                                    src="{{ asset('halaman_depan/assets/img/portfolio/submarine.png') }}"
                                    alt="..." />
                                <!-- Portfolio Modal - Text-->
                                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia
                                    neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore
                                    quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur
                                    itaque. Nam.</p>
                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Close Window
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('halaman_depan/js/scripts.js') }}"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>
