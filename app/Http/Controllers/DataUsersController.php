<?php

namespace App\Http\Controllers;

use App\Exports\DplExport;
use App\Exports\MahasiswaExport;
use App\Exports\PamongExport;
use App\Exports\SekolahExport;
use App\Imports\DataDplImport;
use App\Imports\DataMahasiswaImport;
use App\Imports\DataPamongImport;
use App\Imports\DataSekolahImport;
use App\Imports\ValidateDplHeader;
use App\Models\DataDpl;
use App\Models\DataMahasiswa;
use App\Models\DataPamong;
use App\Models\DataSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::guard('admin')->user();
            $method = $request->route()->getActionMethod();

            // Izinkan role 'sekolah' hanya untuk method 'dataMahasiswa'
            if ($user->role === 'sekolah' && $method === 'dataMahasiswa') {
                return $next($request);
            }
            // Izinkan role 'pamong' hanya untuk method 'dataMahasiswa'
            if ($user->role === 'pamong' && $method === 'dataMahasiswa') {
                return $next($request);
            }

            // Izinkan role 'sekolah' hanya untuk method 'dataPamong'
            if ($user->role === 'sekolah' && $method === 'dataPamong') {
                return $next($request);
            } elseif ($user->role === 'sekolah' && $method === 'viewMahasiswaPamong') {
                return $next($request);
            }

            // Role admin dan dpl tetap bisa akses semua
            if (!in_array($user->role, ['admin', 'dpl'])) {
                return redirect('admin/dashboard')->with('error', 'Anda tidak memiliki izin.');
            }

            return $next($request);
        });
    }

    public function dataDpl(Request $request)
    {
        // // Ambil data dari database
        // $datadpls = DB::table('data_dpls')->paginate(10);

        // // Kirim ke view
        // return view('pages.datausers.datadpl.index', [
        //     "datadpls" => $datadpls,
        // ]);
        
        $search = $request->input('search');

        $query = DB::table('data_dpls');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // $datadpls = $query->paginate(10)->withQueryString();
        $datadpls = $query->paginate(10);
        $datadpls->appends(request()->query());

        // Kirim ke view
        return view('pages.datausers.datadpl.index', [
            "datadpls" => $datadpls,
        ]);
    }

    public function viewMahasiswa($id)
    {
        // Ambil data dari database
        $datamahasiswas = DataMahasiswa::with(['dataSekolah', 'dataPamong', 'penilaian'])
            ->where('dpl_id', $id)
            ->paginate(10);

        foreach ($datamahasiswas as $mhs) {
            // Ambil link tugas berdasarkan nim dan ambil field 'link'
            $task = DB::table('tasks')
                ->where('nim', $mhs->nim)
                ->first(); // Ambil tugas pertama yang cocok dengan nim

            // ini untuk versi 8+
            // $mhs->link = $task?->link ?? null;
            // ini untuk versi 8 kebawah
            $mhs->link = $task ? $task->link : null;
        }

        // Kirim ke view
        return view('pages.datausers.datadpl.view-mahasiswa', [
            "datamahasiswas" => $datamahasiswas,
        ]);
    }

    public function viewMahasiswaSekolah($id)
    {

        // Ambil data dari database
        $datamahasiswas = DataMahasiswa::with(['dataSekolah', 'dataPamong', 'dataDpl', 'penilaian'])
            ->where('sekolah_id', $id)
            ->paginate(10);

        foreach ($datamahasiswas as $mhs) {
            // Ambil link tugas berdasarkan nim dan ambil field 'link'
            $task = DB::table('tasks')
                ->where('nim', $mhs->nim)
                ->first(); // Ambil tugas pertama yang cocok dengan nim

            // ini untuk versi 8+
            // $mhs->link = $task?->link ?? null;
            // ini untuk versi 8 kebawah
            $mhs->link = $task ? $task->link : null;
        }

        return view('pages.datausers.datasekolah.view-mahasiswasekolah', [
            "datamahasiswas" => $datamahasiswas,
        ]);
    }

    public function viewMahasiswaPamong($id)
    {

        // Ambil data dari database
        $datamahasiswas = DataMahasiswa::with(['dataSekolah', 'dataPamong', 'dataDpl', 'penilaian'])
            ->where('pamong_id', $id)
            ->paginate(10);

        foreach ($datamahasiswas as $mhs) {
            // Ambil link tugas berdasarkan nim dan ambil field 'link'
            $task = DB::table('tasks')
                ->where('nim', $mhs->nim)
                ->first(); // Ambil tugas pertama yang cocok dengan nim

            // ini untuk versi 8+
            // $mhs->link = $task?->link ?? null;
            // ini untuk versi 8 kebawah
            $mhs->link = $task ? $task -> link : null;
        }

        return view('pages.datausers.datapamong.view-mahasiswapamong', [
            "datamahasiswas" => $datamahasiswas,
        ]);
    }

    // create data dpl
    public function dataDplCreate()
    {
        // Kirim ke view
        return view('pages.datausers.datadpl.create');
    }

    // store data dpl (saat create perlu store ini untuk menyimpan)
    public function dataDplStore(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|numeric|unique:data_dpls,nip',
            'nama' => 'required|string|max:255',
            'golongan' => 'required',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'nip.required' => 'NIP harus diisi!',
            'nip.numeric' => 'NIP harus berupa angka!',
            'nip.unique' => 'NIP sudah terdaftar, silakan gunakan NIP lain!',
            'nama.required' => 'Nama harus diisi!',
            'nama.string' => 'Nama harus berupa huruf!',
            'golongan.string' => 'Golongan harus diisi!',
            'jabatan.string' => 'Jabatan harus diisi!',
        ]);

        DataDpl::create($validated);

        // return redirect('/admin/datadpl');
        return redirect()->route('datadpl');
    }

    // edit data dpl
    public function dataDplEdit($id)
    {
        $datadpl = DataDpl::findOrFail($id);

        // Kirim ke view
        return view('pages.datausers.datadpl.edit', [
            "datadpl" => $datadpl,
        ]);
    }

    // update data dpl (saat edit perlu update ini untuk menyimpan)
    public function dataDplUpdate(Request $request, $id)
    {
        $datadpl = DataDpl::findOrFail($id);

        $validated = $request->validate([
            'nip' => [
                'required',
                'numeric',
                Rule::unique('data_dpls', 'nip')->ignore($datadpl->id),
            ],
            'nama' => 'required|string|max:255',
            'golongan' => 'required',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'nip.required' => 'NIP harus diisi!',
            'nip.numeric' => 'NIP harus berupa angka!',
            'nip.unique' => 'NIP sudah terdaftar, silakan gunakan NIM lain!',
            'nama.required' => 'Nama harus diisi!',
            'golongan.required' => 'Golongan harus diisi!',
            'Jabatan.required' => 'Jabatan harus diisi!',
        ]);

        // Update data dpl, jika ingin lebih aman
        $datadpl->update($validated);

        // return redirect('/admin/datadpl');
        return redirect()->route('datadpl')->with('success', 'Data Dpl berhasil diperbarui!');
    }

    //delete data dpl
    public function dataDplDelete($id)
    {
        $datadpl = DataDpl::findOrFail($id);
        $datadpl->delete();

        return redirect()->route('datadpl')->with('success', 'Data Dpl berhasil dihapus!');
    }


    public function importExcelDpl(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // $file = $request->file('file');
        // $path = $file->getRealPath();

        // // Baca file pakai PhpSpreadsheet
        // $spreadsheet = IOFactory::load($path);
        // $sheet = $spreadsheet->getActiveSheet();
        // $headingRow = $sheet->rangeToArray('A1:' . $sheet->getHighestColumn() . '1')[0];

        // $expectedHeaders = ['nip', 'nama', 'golongan', 'jabatan', 'jenis_kelamin'];
        // $missing = [];

        // foreach ($expectedHeaders as $expected) {
        //     if (!in_array($expected, $headingRow)) {
        //         $missing[] = $expected;
        //     }
        // }

        // if (!empty($missing)) {
        //     return redirect()->back()->with('header_error', [
        //         'Kolom berikut tidak ditemukan: ' . implode(', ', $missing)
        //     ]);
        // }

        // // Ambil semua data dari Excel
        // $data = $sheet->toArray(null, true, true, true); // huruf kolom sebagai key

        // // Buat mapping heading ('nip' => 'A', dst)
        // $headerMap = [];
        // $columnIndex = range('A', $sheet->getHighestColumn());

        // foreach ($headingRow as $index => $columnName) {
        //     $headerMap[strtolower($columnName)] = $columnIndex[$index];
        // }

        // $duplicateNips = [];

        // foreach ($data as $index => $row) {
        //     if ($index === 1) continue; // lewati baris header

        //     $nip = $row[$headerMap['nip']] ?? null;

        //     if ($nip && DataDpl::where('nip', $nip)->exists()) {
        //         $duplicateNips[] = $nip;
        //     }
        // }

        // if (!empty($duplicateNips)) {
        //     return redirect()->back()->with('duplicate_error', [
        //         'NIP berikut sudah ada di database: ' . implode(', ', $duplicateNips)
        //     ]);
        // }
        
        try {
            // Jika tidak ada duplikat, lanjut import
            Excel::import(new DataDplImport, $request->file('file'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal!');
        }
        

        return redirect()->back()->with('success', 'Import data DPL berhasil!');
    }

    public function exportExcelDpl()
    {
        return Excel::download(new DplExport, 'datadpl.xlsx');
    }

    public function dataSekolah(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $search = $request->input('search');

        $query = DataSekolah::with('dataDpl');

        if ($user->role === 'dpl') {
            $dpl = DataDpl::where('nip', $user->nip)->first();

            if (!$dpl) {
                return back()->withErrors(['msg' => 'Data DPL tidak ditemukan untuk user ini.']);
            }
            $query->where('dpl_id', $dpl->id);
        } 

        // Filter berdasarkan pencarian jika ada
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                    ->orWhere('npsn', 'like', "%{$search}%");
            });
        }

        // $datasekolahs = $query->paginate(10)->withQueryString();
        $datasekolahs = $query->paginate(10);
        $datasekolahs->appends(request()->query());

        // Kirim ke view
        return view('pages.datausers.datasekolah.index', [
            "datasekolahs" => $datasekolahs,
        ]);
    }

    // create data dpl
    public function dataSekolahCreate()
    {
        $dpls = DataDpl::all();
        // Kirim ke view
        return view('pages.datausers.datasekolah.create', [
            "dpls" => $dpls,
        ]);
    }

    // store data dpl (saat create perlu store ini untuk menyimpan)
    public function dataSekolahStore(Request $request)
    {
        $validated = $request->validate([
            'npsn' => 'required|numeric|unique:data_sekolahs,npsn',
            'nama_sekolah' => 'required',
            'dpl_id' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ], [
            'npsn.required' => 'npsn harus diisi!',
            'npsn.numeric' => 'npsn harus berupa angka!',
            'npsn.unique' => 'npsn sudah terdaftar, silakan gunakan npsn lain!',
            'nama_sekolah.required' => 'Nama sekolah harus diisi!',
            'alamat.required' => 'alamat harus diisi!',
            'kota.required' => 'kota harus diisi!',
            'provinsi.required' => 'provinsi harus diisi!',
        ]);

        DataSekolah::create($validated);

        // return redirect('/admin/datadpl');
        return redirect()->route('datasekolah');
    }

    public function dataSekolahEdit($id)
    {
        $dpls = DataDpl::all();
        $datasekolah = DataSekolah::findOrFail($id);

        // Kirim ke view
        return view('pages.datausers.datasekolah.edit', [
            "dpls" => $dpls,
            "datasekolah" => $datasekolah,
        ]);
    }

    public function dataSekolahUpdate(Request $request, $id)
    {
        $datasekolah = DataSekolah::findOrFail($id);

        $validated = $request->validate([
            'npsn' => [
                'required',
                'numeric',
                Rule::unique('data_sekolahs', 'npsn')->ignore($datasekolah->id),
            ],
            'nama_sekolah' => 'required',
            'dpl_id' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ], [
            'nip.required' => 'NIP harus diisi!',
            'nip.numeric' => 'NIP harus berupa angka!',
            'nip.unique' => 'NIP sudah terdaftar, silakan gunakan NIM lain!',
            'nama_sekolah.required' => 'Nama Sekolah harus diisi!',
            'alamat.required' => 'Alamat harus diisi!',
            'kota.required' => 'Kota harus diisi!',
            'provinsi.required' => 'Provinsi harus diisi!',
        ]);

        // Update data sekolah, jika ingin lebih aman
        $datasekolah->update($validated);

        // return redirect('/admin/datasekolah');
        return redirect()->route('datasekolah')->with('success', 'Data Sekolah berhasil diperbarui!');
    }

    //delete data sekolah
    public function dataSekolahDelete($id)
    {
        $datasekolah = DataSekolah::findOrFail($id);
        $datasekolah->delete();

        return redirect()->route('datasekolah')->with('success', 'Data Sekolah berhasil dihapus!');
    }


    public function importExcelSekolah(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // $file = $request->file('file');
        // $path = $file->getRealPath();

        // // Baca file pakai PhpSpreadsheet
        // $spreadsheet = IOFactory::load($path);
        // $sheet = $spreadsheet->getActiveSheet();
        // $headingRow = $sheet->rangeToArray('A1:' . $sheet->getHighestColumn() . '1')[0];

        // // Daftar header yang wajib ada
        // $expectedHeaders = ['npsn', 'nama_sekolah', 'nip_dpl', 'alamat', 'kota', 'provinsi', 'longitude', 'latitude'];
        // $missing = [];

        // foreach ($expectedHeaders as $expected) {
        //     if (!in_array($expected, $headingRow)) {
        //         $missing[] = $expected;
        //     }
        // }

        // if (!empty($missing)) {
        //     return redirect()->back()->with('header_error', ['Kolom berikut tidak ditemukan: ' . implode(', ', $missing)]);
        // }

        // // Ambil semua data dari Excel
        // $data = $sheet->toArray(null, true, true, true); // huruf kolom sebagai key

        // // Buat mapping heading ('npsn' => 'A', dst)
        // $headerMap = [];
        // $columnIndex = range('A', $sheet->getHighestColumn());

        // foreach ($headingRow as $index => $columnName) {
        //     $headerMap[strtolower($columnName)] = $columnIndex[$index];
        // }

        // $duplicateNpsns = [];

        // foreach ($data as $index => $row) {
        //     if ($index === 1) continue; // lewati baris header

        //     $npsn = $row[$headerMap['npsn']] ?? null;

        //     if ($npsn && DataSekolah::where('npsn', $npsn)->exists()) {
        //         $duplicateNpsns[] = $npsn;
        //     }
        // }

        // if (!empty($duplicateNpsns)) {
        //     return redirect()->back()->with('duplicate_error', [
        //         'NPSN berikut sudah ada di database: ' . implode(', ', $duplicateNpsns)
        //     ]);
        // }

        // // Lanjut import jika semua header valid
        // Excel::import(new DataSekolahImport, $path);
        
        try {
            // Jika tidak ada duplikat, lanjut import
            Excel::import(new DataSekolahImport, $request->file('file'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal!');
        }
        

        return redirect()->back()->with('success', 'Import data Sekolah berhasil!');
    }

    public function exportExcelSekolah()
    {
        return Excel::download(new SekolahExport, 'datasekolah.xlsx');
    }

    public function dataPamong(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $search = $request->input('search');

        $query = DataPamong::with('dataSekolah');

        if ($user->role === 'dpl') {
            $dpl = DataDpl::where('nip', $user->nip)->first();

            if (!$dpl) {
                return back()->withErrors(['msg' => 'Data DPL tidak ditemukan untuk user ini.']);
            }
            // Ambil sekolah dari mahasiswa yang dibimbing oleh DPL ini
        $sekolahIds = DataMahasiswa::where('dpl_id', $dpl->id)
                        ->pluck('sekolah_id')
                        ->unique();

        $query->whereIn('sekolah_id', $sekolahIds);
        } elseif ($user->role === 'sekolah') {
            $sekolah = DataSekolah::where('npsn', $user->npsn)->first();
            $query->where('sekolah_id', $sekolah->id);
        } 

        // Filter berdasarkan pencarian jika ada
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // $datapamongs = $query->paginate(10)->withQueryString();
        $datapamongs = $query->paginate(10);
        $datapamongs->appends(request()->query());

        // Kirim ke view
        return view('pages.datausers.datapamong.index', [
            "datapamongs" => $datapamongs,
        ]);
    }

    public function dataPamongCreate()
    {
        $sekolahs = DataSekolah::all();

        // Kirim ke view
        return view('pages.datausers.datapamong.create', [
            "sekolahs" => $sekolahs,
        ]);
    }

    public function dataPamongStore(Request $request)
    {

        $validated = $request->validate([
            'nip' => 'required|numeric|unique:data_pamongs,nip',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'golongan' => 'nullable',
            'jabatan' => 'nullable',
            'sekolah_id' => 'nullable',
        ], [
            'nip.required' => 'NIP harus diisi!',
            'nip.numeric' => 'NIP harus berupa angka!',
            'nip.unique' => 'NIP sudah terdaftar, silakan gunakan NIP lain!',
            'nama.required' => 'Nama harus diisi!',
            'nama.string' => 'Nama harus berupa huruf!',
        ]);

        DataPamong::create($validated);

        // return redirect('/admin/datapamong');
        return redirect()->route('datapamong');
    }

    public function dataPamongEdit($id)
    {
        $sekolahs = DataSekolah::all();
        $datapamong = DataPamong::findOrFail($id);

        // Kirim ke view
        return view('pages.datausers.datapamong.edit', [
            "sekolahs" => $sekolahs,
            "datapamong" => $datapamong,
        ]);
    }

    public function dataPamongUpdate(Request $request, $id)
    {
        $datapamong = DataPamong::findOrFail($id);

        $validated = $request->validate([
            'nip' => [
                'required',
                'numeric',
                Rule::unique('data_pamongs', 'nip')->ignore($datapamong->id),
            ],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'golongan' => 'required',
            'jabatan' => 'required',
            'sekolah_id' => 'required',
        ]);

        // Update data pamong, jika ingin lebih aman
        $datapamong->update($validated);

        // return redirect('/admin/datapamong');
        return redirect()->route('datapamong')->with('success', 'Data pamong berhasil diperbarui!');
    }

    public function dataPamongDelete($id)
    {
        $datapamong = DataPamong::findOrFail($id);
        $datapamong->delete();

        return redirect()->route('datapamong')->with('success', 'Data pamong berhasil dihapus!');
    }


    public function importExcelPamong(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // $file = $request->file('file');
        // $path = $file->getRealPath();

        // // Baca file pakai PhpSpreadsheet
        // $spreadsheet = IOFactory::load($path);
        // $sheet = $spreadsheet->getActiveSheet();
        // $headingRow = $sheet->rangeToArray('A1:' . $sheet->getHighestColumn() . '1')[0];

        // // Daftar header yang wajib ada
        // $expectedHeaders = ['nip_atau_nik', 'nama', 'jenis_kelamin', 'golongan', 'jabatan', 'npsn_sekolah'];
        // $missing = [];

        // foreach ($expectedHeaders as $expected) {
        //     if (!in_array($expected, $headingRow)) {
        //         $missing[] = $expected;
        //     }
        // }

        // if (!empty($missing)) {
        //     return redirect()->back()->with('header_error', ['Kolom berikut tidak ditemukan: ' . implode(', ', $missing)]);
        // }

        // // ini ditambah untuk duplikat
        // // Ambil semua data dari Excel
        // $data = $sheet->toArray(null, true, true, true); // huruf kolom sebagai key

        // // Buat mapping heading ('nip' => 'A', dst)
        // $headerMap = [];
        // $columnIndex = range('A', $sheet->getHighestColumn());

        // foreach ($headingRow as $index => $columnName) {
        //     $headerMap[strtolower($columnName)] = $columnIndex[$index];
        // }

        // $duplicateNips = [];

        // foreach ($data as $index => $row) {
        //     if ($index === 1) continue; // lewati baris header

        //     $nip = $row[$headerMap['nip_atau_nik']] ?? null;

        //     if ($nip && DataPamong::where('nip', $nip)->exists()) {
        //         $duplicateNips[] = $nip;
        //     }
        // }

        // if (!empty($duplicateNips)) {
        //     return redirect()->back()->with('duplicate_error', [
        //         'NIP atau NIK berikut sudah ada di database: ' . implode(', ', $duplicateNips)
        //     ]);
        // }

        // Lanjut import jika semua header valid
        // Excel::import(new DataPamongImport, $path);
        
        try {
            // Jika tidak ada duplikat, lanjut import
            Excel::import(new DataPamongImport, $request->file('file'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal!');
        }

        return redirect()->back()->with('success', 'Import data Pamong berhasil!');
    }

    public function exportExcelPamong()
    {
        return Excel::download(new PamongExport, 'datapamong.xlsx');
    }

    public function dataMahasiswa(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $search = $request->input('search');

        $query = DataMahasiswa::with(['dataDpl', 'dataSekolah', 'dataPamong']);

        // Filter berdasarkan role pengguna
        if ($user->role === 'sekolah') {
            $sekolah = DataSekolah::where('npsn', $user->npsn)->first();
            $query->where('sekolah_id', $sekolah->id);
        } elseif ($user->role === 'dpl') {
            $dpl = DataDpl::where('nip', $user->nip)->first();
            if (!$dpl) return back()->withErrors(['msg' => 'Data DPL tidak ditemukan untuk user ini.']);
            $query->where('dpl_id', $dpl->id);
        } elseif ($user->role === 'pamong') {
            $pamong = DataPamong::where(function ($q) use ($user) {
                $q->where('nip', $user->nip)
                    ->orWhere('nip', $user->nik);
            })->first();
            if (!$pamong) return back()->withErrors(['msg' => 'Data pamong tidak ditemukan untuk user ini.']);
            $query->where('pamong_id', $pamong->id);
        }

        // Filter berdasarkan pencarian jika ada
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // $datamahasiswas = $query->paginate(10)->withQueryString();
        $datamahasiswas = $query->paginate(10);
        $datamahasiswas->appends(request()->query());

        // Kirim ke view
        return view('pages.datausers.datamahasiswa.index', [
            "datamahasiswas" => $datamahasiswas,
        ]);
    }

    // create data mahasiswa
    public function dataMahasiswaCreate()
    {
        $dpls = DataDpl::all();
        $sekolahs = DataSekolah::all();
        $pamongs = DataPamong::all();

        // Kirim ke view
        return view('pages.datausers.datamahasiswa.create', [
            "dpls" => $dpls,
            "sekolahs" => $sekolahs,
            "pamongs" => $pamongs,
        ]);
    }

    // store data mahasiswa (saat create perlu store ini untuk menyimpan)
    public function dataMahasiswaStore(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|numeric|unique:data_mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'jurusan' => 'required',
            'dpl_id' => 'nullable',
            'sekolah_id' => 'nullable',
            'pamong_id' => 'nullable',
        ], [
            'nim.required' => 'NIM harus diisi!',
            'nim.numeric' => 'NIM harus berupa angka!',
            'nim.unique' => 'NIM sudah terdaftar, silakan gunakan NIM lain!',
            'nama.required' => 'Nama harus diisi!',
            'nama.string' => 'Nama harus berupa huruf!',
            'jurusan.required' => 'Jurusan harus diisi!',
        ]);

        DataMahasiswa::create($validated);

        // return redirect('/admin/datamahasiswa');
        return redirect()->route('datamahasiswa');
    }

    // edit data dpl
    public function dataMahasiswaEdit($id)
    {
        $dpls = DataDpl::all();
        $sekolahs = DataSekolah::all();
        $pamongs = DataPamong::all();
        $datamahasiswa = DataMahasiswa::findOrFail($id);

        // Kirim ke view
        return view('pages.datausers.datamahasiswa.edit', [
            "dpls" => $dpls,
            "sekolahs" => $sekolahs,
            "pamongs" => $pamongs,
            "datamahasiswa" => $datamahasiswa,
        ]);
    }

    // update data dpl (saat edit perlu update ini untuk menyimpan)
    public function dataMahasiswaUpdate(Request $request, $id)
    {
        $datamahasiswa = DataMahasiswa::findOrFail($id);

        $validated = $request->validate([
            'nim' => [
                'required',
                'numeric',
                Rule::unique('data_mahasiswas', 'nim')->ignore($datamahasiswa->id),
            ],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'jurusan' => 'required',
            'dpl_id' => 'nullable',
            'sekolah_id' => 'nullable',
            'pamong_id' => 'nullable',
        ]);

        // update jika hanya ingin langsung update tanpa perlu validasi
        // DataMahasiswa::where('id', $id)->update([
        //     "nim" => $request->input('nim'),
        //     "nama" => $request->input('nama'),
        //     "jenis_kelamin" => $request->input('jenis_kelamin'),
        //     "jurusan" => $request->input('jurusan'),
        //     "dpl_id" => $request->input('dpl_id'),
        //     "sekolah_id" => $request->input('sekolah_id'),
        //     "pamong_id" => $request->input('pamong_id'),
        // ]);

        // Update data mahasiswa, jika ingin lebih aman
        $datamahasiswa->update($validated);

        // return redirect('/admin/datamahasiswa');
        return redirect()->route('datamahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    //delete data mahasiswa
    public function dataMahasiswaDelete($id)
    {
        $datamahasiswa = DataMahasiswa::findOrFail($id);
        $datamahasiswa->delete();

        return redirect()->route('datamahasiswa')->with('success', 'Data mahasiswa berhasil dihapus!');
    }


    public function importExcelMahasiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // $file = $request->file('file');
        // $path = $file->getRealPath();

        // // Baca file pakai PhpSpreadsheet
        // $spreadsheet = IOFactory::load($path);
        // $sheet = $spreadsheet->getActiveSheet();
        // $headingRow = $sheet->rangeToArray('A1:' . $sheet->getHighestColumn() . '1')[0];

        // // Daftar header yang wajib ada
        // // $expectedHeaders = ['nim', 'nama', 'nip_dpl', 'npsn_sekolah', 'nip_pamong'];
        // $expectedHeaders = ['nim', 'nama', 'jenis_kelamin', 'nip_dpl', 'npsn_sekolah', 'nip_pamong'];
        // $missing = [];

        // foreach ($expectedHeaders as $expected) {
        //     if (!in_array($expected, $headingRow)) {
        //         $missing[] = $expected;
        //     }
        // }

        // if (!empty($missing)) {
        //     return redirect()->back()->with('header_error', [
        //         'Kolom berikut tidak ditemukan: ' . implode(', ', $missing)
        //     ]);
        // }

        // // ini yng ditambah untk duplikat
        // // Ambil semua data dari Excel
        // $data = $sheet->toArray(null, true, true, true); // huruf kolom sebagai key

        // // Buat mapping heading ('nim' => 'A', dst)
        // $headerMap = [];
        // $columnIndex = range('A', $sheet->getHighestColumn());

        // foreach ($headingRow as $index => $columnName) {
        //     $headerMap[strtolower($columnName)] = $columnIndex[$index];
        // }

        // $duplicateNims = [];

        // foreach ($data as $index => $row) {
        //     if ($index === 1) continue; // lewati baris header

        //     $nim = $row[$headerMap['nim']] ?? null;

        //     if ($nim && DataMahasiswa::where('nim', $nim)->exists()) {
        //         $duplicateNims[] = $nim;
        //     }
        // }

        // if (!empty($duplicateNims)) {
        //     return redirect()->back()->with('duplicate_error', [
        //         'NIM berikut sudah ada di database: ' . implode(', ', $duplicateNims)
        //     ]);
        // }

        // Lanjut import jika semua header valid
        // Excel::import(new DataMahasiswaImport, $path);
        
        try {
            // Jika tidak ada duplikat, lanjut import
            Excel::import(new DataMahasiswaImport, $request->file('file'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal!');
        }

        return redirect()->back()->with('success', 'Import data Mahasiswa berhasil!');
    }

    public function exportExcelMahasiswa()
    {
        return Excel::download(new MahasiswaExport, 'datamahasiswa.xlsx');
    }
}