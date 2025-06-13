<?php

use App\Http\Controllers\CreateAccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataUsersController;
use App\Http\Controllers\KebutuhanPplController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\NilaiAkhirController;
use App\Http\Controllers\PdfPenilaianController;
use App\Http\Controllers\PdfPenilaianDplController;
use App\Http\Controllers\PengajuanPplController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenilaianDplController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\TasksController;
use App\Models\KebutuhanPpl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// halaman depan
Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('dashboard');
    }
    return view('halamanDepan.index');
});

// login
Route::group([
    'prefix' => config('admin.prefix'),
    'namespace' => 'App\\Http\\Controllers',
], function () {
    Route::get('/login', [LoginAdminController::class, 'FormLogin'])->name('admin.login');
    Route::post('/login', [LoginAdminController::class, 'login']);


    Route::get('/get-jurusan-tersisa', [KebutuhanPplController::class, 'getJurusanTersisa'])
        ->name('get-jurusan-tersisa');

    Route::middleware(['auth:admin', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
        Route::post('/logout', [LoginAdminController::class, 'logout'])->name('admin.logout');

        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // kebutuhan ppl
        Route::get('/kuotappl', [KebutuhanPplController::class, 'kuotaPpl'])
            ->name('kuotappl');
        Route::get('/kuotappl/create', [KebutuhanPplController::class, 'create'])
            ->name('kuotappl.create');
        Route::post('/kuotappl/store', [KebutuhanPplController::class, 'store'])
            ->name('kuotappl.store');
        Route::delete('/kuotappl/{id}', [KebutuhanPplController::class, 'delete'])
            ->name('kuotappl.delete');

        // detail kebutuhan ppl untuk admin (lihat per sekolah dan tahun ajaran)
        Route::get('/kebutuhan-ppl/detail', [KebutuhanPplController::class, 'detail'])
            ->name('kebutuhanppl.detail');

        Route::delete('/kebutuhanppl/{sekolah}/{tahun}', [KebutuhanPplController::class, 'deletePerSekolahTahun'])
            ->where('tahun', '[0-9]{4}/[0-9]{4}')
            ->name('kebutuhanppl.deletePerSekolahTahun');

        // form pendaftaran ppl (untuk mahasiswa)
        Route::get('/pendaftaran-ppl', [PengajuanPplController::class, 'create'])
            ->name('pendaftaran.ppl');
        Route::post('/pendaftaran-ppl', [PengajuanPplController::class, 'store'])
            ->name('pendaftaran.ppl.store');

        // Untuk admin 
        Route::get('/admin/pengajuan-ppl', [PengajuanPplController::class, 'index'])
            ->name('admin.pengajuan.ppl');
        Route::post('/admin/pengajuan-ppl/{id}/{status}', [PengajuanPplController::class, 'updateStatus'])
            ->name('admin.pengajuan.ppl.update');

        // ubah yang tadinya view menjadi get, untuk semua menu seperti /datadpl, /kelolatugas
        // data dpl
        Route::get('/datadpl', [DataUsersController::class, 'dataDpl'])
            ->name('datadpl');
        Route::get('/datadpl/create', [DataUsersController::class, 'dataDplCreate'])
            ->name('datadplcreate');
        Route::get('/datadpl/edit/{id}', [DataUsersController::class, 'dataDplEdit'])
            ->name('datadpledit');
        Route::post('/datadpl/store', [DataUsersController::class, 'dataDplStore'])
            ->name('datadplstore');
        Route::put('/datadpl/{id}', [DataUsersController::class, 'dataDplUpdate'])
            ->name('datadplupdate');
        Route::delete('/datadpl/{id}', [DataUsersController::class, 'dataDplDelete'])
            ->name('datadpldelete');

        Route::get('/datadpl/view-mahasiswa/{id}', [DataUsersController::class, 'viewMahasiswa'])
            ->name('viewmahasiswa');
        Route::get('/datasekolah/view-mahasiswa/{id}', [DataUsersController::class, 'viewMahasiswaSekolah'])
            ->name('viewmahasiswasekolah');
        Route::get('/datapamong/view-mahasiswa/{id}', [DataUsersController::class, 'viewMahasiswaPamong'])
            ->name('viewmahasiswapamong');

        // data sekolah
        Route::get('/datasekolah', [DataUsersController::class, 'dataSekolah'])
            ->name('datasekolah');
        Route::get('/datasekolah/create', [DataUsersController::class, 'dataSekolahCreate'])
            ->name('datasekolahcreate');
        Route::get('/datasekolah/edit/{id}', [DataUsersController::class, 'dataSekolahEdit'])
            ->name('datasekolahedit');
        Route::post('/datasekolah/store', [DataUsersController::class, 'dataSekolahStore'])
            ->name('datasekolahstore');
        Route::put('/datasekolah/{id}', [DataUsersController::class, 'dataSekolahUpdate'])
            ->name('datasekolahupdate');
        Route::delete('/datasekolah/{id}', [DataUsersController::class, 'dataSekolahDelete'])
            ->name('datasekolahdelete');

        // data pamong
        Route::get('/datapamong', [DataUsersController::class, 'dataPamong'])
            ->name('datapamong');
        Route::get('/datapamong/create', [DataUsersController::class, 'dataPamongCreate'])
            ->name('datapamongcreate');
        Route::get('/datapamong/edit/{id}', [DataUsersController::class, 'dataPamongEdit'])
            ->name('datapamongedit');
        Route::post('/datapamong/store', [DataUsersController::class, 'dataPamongStore'])
            ->name('datapamongstore');
        Route::put('/datapamong/{id}', [DataUsersController::class, 'dataPamongUpdate'])
            ->name('datapamongupdate');
        Route::delete('/datapamong/{id}', [DataUsersController::class, 'dataPamongDelete'])
            ->name('datapamongdelete');

        // data mahasiswa
        Route::get('/datamahasiswa', [DataUsersController::class, 'dataMahasiswa'])
            ->name('datamahasiswa');
        Route::get('/datamahasiswa/create', [DataUsersController::class, 'dataMahasiswaCreate'])
            ->name('datamahasiswacreate');
        Route::get('/datamahasiswa/edit/{id}', [DataUsersController::class, 'dataMahasiswaEdit'])
            ->name('datamahasiswaedit');
        Route::post('/datamahasiswa/store', [DataUsersController::class, 'dataMahasiswaStore'])
            ->name('datamahasiswastore');
        Route::put('/datamahasiswa/{id}', [DataUsersController::class, 'dataMahasiswaUpdate'])
            ->name('datamahasiswaupdate');
        Route::delete('/datamahasiswa/{id}', [DataUsersController::class, 'dataMahasiswaDelete'])
            ->name('datamahasiswadelete');

        // import excel dpl
        Route::post('/importexcel/dpl', [DataUsersController::class, 'importExcelDpl'])
            ->name('importexceldpl');
        // export excel dpl
        Route::get('/exportexcel/dpl', [DataUsersController::class, 'exportExcelDpl'])
            ->name('exportexceldpl');

        // import excel mahasiswa
        Route::post('/importexcel/mahasiswa', [DataUsersController::class, 'importExcelMahasiswa'])
            ->name('importexcelmahasiswa');
        // import excel mahasiswa
        Route::get('/exportexcel/mahasiswa', [DataUsersController::class, 'exportExcelMahasiswa'])
            ->name('exportexcelmahasiswa');

        // import excel sekolah
        Route::post('/importexcel/sekolah', [DataUsersController::class, 'importExcelSekolah'])
            ->name('importexcelsekolah');
        // import excel sekolah
        Route::get('/exportexcel/sekolah', [DataUsersController::class, 'exportExcelSekolah'])
            ->name('exportexcelsekolah');

        // import excel pamong
        Route::post('/importexcel/pamong', [DataUsersController::class, 'importExcelPamong'])
            ->name('importexcelpamong');
        // import excel pamong
        Route::get('/exportexcel/pamong', [DataUsersController::class, 'exportExcelPamong'])
            ->name('exportexcelpamong');

        // presensi mahasiswa
        Route::get('/presensi/create', [PresensiController::class, 'create'])
            ->name('absencreate');
        Route::post('/presensi/store', [PresensiController::class, 'store'])
            ->name('absenstore');

        // Menampilkan halaman tugas
        Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
        // Menyimpan tugas
        Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');
        // Tampilkan form edit
        Route::get('/tasks/edit/{id}', [TasksController::class, 'edit'])->name('tasks.edit');
        // Proses update data
        Route::put('/tasks/{id}', [TasksController::class, 'update'])->name('tasks.update');
        // proses delete data
        Route::delete('/tasks/{id}', [TasksController::class, 'delete'])
            ->name('tasks.delete');

        // histori absensi admin
        Route::get('/presensi/histori', [PresensiController::class, 'histori'])
            ->name('absenhistori');
        Route::post('/presensi/gethistori', [PresensiController::class, 'gethistori'])
            ->name('gethistori');

        // export pdf histori presensi role admin
        Route::post('/presensi/download-pdf', [PresensiController::class, 'downloadPDF'])
            ->name('downloadpdf');
        Route::post('/presensi/show-pdf', [PresensiController::class, 'showPDF'])
            ->name('showpdf');

        // histori absensi sekolah
        Route::get('/presensi/histori/sekolah', [PresensiController::class, 'historiSekolah'])
            ->name('absenhistorisekolah');
        Route::post('/presensi/gethistori/sekolah', [PresensiController::class, 'gethistoriSekolah'])
            ->name('gethistorisekolah');

        // export pdf histori presensi role sekolah
        Route::post('/presensi/sekolah/download-pdf', [PresensiController::class, 'downloadPDFSekolah'])
            ->name('downloadpdfsekolah');
        Route::post('/presensi/sekolah/show-pdf', [PresensiController::class, 'showPDFSekolah'])
            ->name('showpdfsekolah');

        // histori absen berdasarkan nama dpl
        Route::get('/presensi/histori/dpl', [PresensiController::class, 'historiDpl'])
            ->name('absenhistoridpl');
        Route::post('/presensi/gethistori/dpl', [PresensiController::class, 'gethistoriDpl'])
            ->name('gethistoridpl');

        // export pdf histori presensi role dpl
        Route::post('/presensi/dpl/download-pdf', [PresensiController::class, 'downloadPDFDpl'])
            ->name('downloadpdfdpl');
        Route::post('/presensi/dpl/show-pdf', [PresensiController::class, 'showPDFDpl'])
            ->name('showpdfdpl');

        Route::resource('penilaian', PenilaianController::class)->except(['show']);
        Route::resource('penilaiandpl', PenilaianDplController::class)->except(['show']);

        // export data penilaian pamong
        Route::get('penilaian/download-pdf/{id}', [PdfPenilaianController::class, 'generatePDF'])
            ->name('penilaianpdf');
        Route::get('penilaian/pdf/show/{id}', [PdfPenilaianController::class, 'showPDF'])
            ->name('penilaianpdfshow');

        // export data penilaian dpl
        Route::get('penilaiandpl/download-pdf/{id}', [PdfPenilaianDplController::class, 'generatePDF'])
            ->name('penilaiandplpdf');
        Route::get('penilaian/show-pdf/{id}', [PdfPenilaianDplController::class, 'showPDF'])
            ->name('penilaianpdfdplshow');

        // export data penilaian dpl excel
        Route::get('/penilaian-dpl/export/excel', [PenilaianDplController::class, 'exportExcelPenilaianDpl'])->name('penilaian-dpl.export');

        // nilai akhir mahasiswa
        Route::get('/nilai-akhir', [NilaiAkhirController::class, 'index'])->name('nilaiakhir.index');
        Route::delete('/nilai-akhir/{id}', [NilaiAkhirController::class, 'destroy'])->name('nilaiakhir.destroy');

        // export nilai akhir mahasiswa
        Route::get('/nilai-akhir/export', [NilaiAkhirController::class, 'export'])->name('nilaiakhir.export');

        // add account
        Route::get('/account', [CreateAccountController::class, 'Account'])->name('admin.account');
        Route::get('/create-account', [CreateAccountController::class, 'Create'])->name('accountcreate');
        Route::get('/account/edit/{id}', [CreateAccountController::class, 'Edit'])
            ->name('accountedit');
        Route::post('/account-store', [CreateAccountController::class, 'Store'])
            ->name('accountstore');
        Route::put('/account/{id}', [CreateAccountController::class, 'Update'])
            ->name('accountupdate');
        Route::delete('/account/{id}', [CreateAccountController::class, 'Delete'])
            ->name('accountdelete');

        // add account user via excel import
        Route::get('/import', [CreateAccountController::class, 'showImportForm'])->name('admin.import.form');
        Route::post('/import', [CreateAccountController::class, 'importAccount'])->name('admin.import');
    });
});
