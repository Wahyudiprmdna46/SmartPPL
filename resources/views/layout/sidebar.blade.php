@unless (Auth::guard('admin')->check())
    <!-- Jika pengguna belum login, sidebar tidak ditampilkan -->
@else
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Smart-PPL</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Manajemen Data
        </div>

        <!-- Cek role pengguna sebelum menampilkan menu -->
        {{-- untuk admin --}}
        @can('role', 'admin')
            <li class="nav-item {{ request()->routeIs('kuotappl') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kuotappl') }}">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Kebutuhan PPL</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.pengajuan.ppl') }}">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Pengajuan PPL</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
                    aria-expanded="true" aria-controls="collapseUser">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Data User</span>
                </a>
                <div id="collapseUser" class="collapse" aria-labelledby="headingUser" data-parent="#accordionSidebar">
                    <div class="collapse-inner rounded bg-white py-2">
                        <a class="collapse-item" href="{{ route('datadpl') }}"><i
                                class="fas fa-chalkboard-teacher mr-2"></i>Data DPL</a>
                        <a class="collapse-item" href="{{ route('datamahasiswa') }}"><i
                                class="fas fa-user-graduate mr-2"></i>Data Mahasiswa</a>
                        <a class="collapse-item" href="{{ route('datasekolah') }}"><i class="fas fa-school mr-2"></i>Data
                            Sekolah</a>
                        <a class="collapse-item" href="{{ route('datapamong') }}"><i class="fas fa-user-tie mr-2"></i>Data
                            Pamong</a>
                        <a class="collapse-item" href="{{ route('admin.account') }}"><i
                                class="fas fa-user-cog mr-2"></i>Account
                            Users</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTugas"
                    aria-expanded="true" aria-controls="collapseTugas">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Kelola Tugas</span>
                </a>
                <div id="collapseTugas" class="collapse" aria-labelledby="headingTugas" data-parent="#accordionSidebar">
                    <div class="collapse-inner rounded bg-white py-2">
                        <a class="collapse-item" href="{{ route('tasks.index') }}" title="Kelola Tugas Mahasiswa"><i
                                class="fas fa-book mr-2"></i>Tugas Mahasiswa</a>
                        <a class="collapse-item" href="{{ route('penilaian.index') }}" title="Kelola Penilaian Mahasiswa"><i
                                class="fas fa-star mr-2"></i>
                            Penilaian Pamong</a>
                        <a class="collapse-item" href="{{ route('penilaiandpl.index') }}" title="Kelola Penilaian Mahasiswa">
                            <i class="fas fa-star mr-2"></i>Penilaian DPL</a>
                        <a class="collapse-item" href="{{ route('nilaiakhir.index') }}" title="Nilai Akhir Mahasiswa">
                            <i class="fas fa-star mr-2"></i>Nilai Akhir Mahasiswa</a>
                    </div>
                </div>
            </li>

            <li class="nav-item {{ request()->routeIs('absenhistori') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('absenhistori') }}">
                    <i class="fas fa-fw fa-history"></i>
                    <span>Presensi Histori</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.import.form') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.import.form') }}">
                    <i class="fas fa-fw fa-file-upload"></i>
                    <span>Create User via import</span>
                </a>
            </li>
        @endcan

        @can('role', 'pamong')
            <li class="nav-item {{ request()->routeIs('datamahasiswa') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('datamahasiswa') }}">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Data Mahasiswa</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTugas"
                    aria-expanded="true" aria-controls="collapseTugas">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Kelola Tugas</span>
                </a>
                <div id="collapseTugas" class="collapse" aria-labelledby="headingTugas" data-parent="#accordionSidebar">
                    <div class="collapse-inner rounded bg-white py-2">
                        <a class="collapse-item" href="{{ route('tasks.index') }}" title="Kelola Tugas Mahasiswa">
                            <i class="fas fa-book mr-2"></i>Tugas Mahasiswa</a>
                        <a class="collapse-item" href="{{ route('penilaian.index') }}" title="Kelola Penilaian Mahasiswa">
                            <i class="fas fa-star mr-2"></i>Penilaian Mahasiswa</a>
                    </div>
                </div>
            </li>
        @endcan

        @can('role', 'sekolah')
            <li class="nav-item {{ request()->routeIs('kuotappl') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kuotappl') }}">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Kebutuhan PPL</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseData"
                    aria-expanded="true" aria-controls="collapseData">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Kelola Data Users</span>
                </a>
                <div id="collapseData" class="collapse" aria-labelledby="headingData" data-parent="#accordionSidebar">
                    <div class="collapse-inner rounded bg-white py-2">
                        <a class="collapse-item" href="{{ route('datapamong') }}">
                            <i class="fas fa-user-tie mr-2"></i>Data Pamong</a>
                        <a class="collapse-item" href="{{ route('datamahasiswa') }}">
                            <i class="fas fa-user-graduate mr-2"></i>Data Mahasiswa</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTugas"
                    aria-expanded="true" aria-controls="collapseTugas">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Kelola Tugas</span>
                </a>
                <div id="collapseTugas" class="collapse" aria-labelledby="headingTugas" data-parent="#accordionSidebar">
                    <div class="collapse-inner rounded bg-white py-2">
                        <a class="collapse-item" href="{{ route('tasks.index') }}" title="Kelola Tugas Mahasiswa">
                            <i class="fas fa-book mr-2"></i>Tugas Mahasiswa</a>
                        <a class="collapse-item" href="{{ route('penilaian.index') }}" title="Kelola Penilaian Mahasiswa">
                            <i class="fas fa-star mr-2"></i> Penilaian Mahasiswa</a>
                    </div>
                </div>
            </li>

            <li class="nav-item {{ request()->routeIs('absenhistorisekolah') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('absenhistorisekolah') }}">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Presensi Histori</span>
                </a>
            </li>
        @endcan

        @can('role', 'dpl')
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseData"
                    aria-expanded="true" aria-controls="collapseData">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Kelola Data User</span>
                </a>
                <div id="collapseData" class="collapse" aria-labelledby="headingData" data-parent="#accordionSidebar">
                    <div class="collapse-inner rounded bg-white py-2">
                        <a class="collapse-item" href="{{ route('datasekolah') }}">
                            <i class="fas fa-school mr-2"></i>Data Sekolah</a>
                        <a class="collapse-item" href="{{ route('datapamong') }}">
                            <i class="fas fa-user-tie mr-2"></i>Data Pamong</a>
                        <a class="collapse-item" href="{{ route('datamahasiswa') }}">
                            <i class="fas fa-user-graduate mr-2"></i>Data Mahasiswa</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTugas"
                    aria-expanded="true" aria-controls="collapseTugas">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Kelola Tugas Mahasiswa</span>
                </a>
                <div id="collapseTugas" class="collapse" aria-labelledby="headingTugas" data-parent="#accordionSidebar">
                    <div class="collapse-inner rounded bg-white py-2">
                        <a class="collapse-item" href="{{ route('tasks.index') }}">
                            <i class="fas fa-book mr-2"></i>Tugas Mahasiswa</a>
                        <a class="collapse-item" href="{{ route('penilaian.index') }}" title="Kelola Penilaian Pamong">
                            <i class="fas fa-star mr-2"></i>Penilaian Pamong</a>
                        <a class="collapse-item" href="{{ route('penilaiandpl.index') }}" title="Kelola Penilaian Dpl">
                            <i class="fas fa-star mr-2"></i>Penilaian DPL</a>
                        <a class="collapse-item" href="{{ route('nilaiakhir.index') }}" title="Nilai Akhir Mahasiswa">
                            <i class="fas fa-star mr-2"></i>Nilai Akhir Mahasiswa</a>
                    </div>
                </div>
            </li>
            <li class="nav-item {{ request()->routeIs('absenhistoridpl') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('absenhistoridpl') }}">
                    <i class="fas fa-fw fa-history"></i>
                    <span>Presensi Histori</span>
                </a>
            </li>
        @endcan

        {{-- menu mahasiswa --}}
        @can('role', 'mahasiswa')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pendaftaran.ppl') }}">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Pendaftaran PPL</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tasks.index') }}">
                    <i class="fas fa-fw fa-upload"></i>
                    <span>Upload Tugas Akhir</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('absencreate') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('absencreate') }}">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Absensi</span>
                </a>
            </li>
        @endcan

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="d-none d-md-inline text-center">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
@endunless
