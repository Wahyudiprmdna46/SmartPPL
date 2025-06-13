<?php

namespace App\Http\Controllers;

use App\Models\presensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nim = Auth::guard('admin')->user()->nim;
        $cek = DB::table('presensis')->where('tgl_presensi', $hariini)->where('nim', $nim)->count();
        return view('pages.absensi.create', compact('cek'));
    }

    public function store(Request $request)
    {
        // ambil data
        $nim = Auth::guard('admin')->user()->nim;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;

        // cek apakah sudah login/belum
        $cek = DB::table('presensis')->where('tgl_presensi', $tgl_presensi)->where('nim', $nim)->count();

        // tentukan apakah absen masuk/pulang
        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }

        // menyimpan gambar dan menampilkannya di view
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nim . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;

        if ($cek > 0) {
            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi,
            ];
            $update = DB::table('presensis')->where('tgl_presensi', $tgl_presensi)->where('nim', $nim)->update($data_pulang);
            if ($update) {
                echo "success|Terimakasih, Hati-Hati dijalan|out";
                Storage::put($file, $image_base64);
            } else {
                echo "error|Maaf Gagal Absen, Silahkan Hubungi IT|out";
            }
        } else {
            $data = [
                'nim' => $nim,
                'tgl_presensi' => $tgl_presensi,
                'jam_in' => $jam,
                'foto_in' => $fileName,
                'lokasi_in' => $lokasi,
            ];
            $simpan = DB::table('presensis')->insert($data);
            if ($simpan) {
                echo "success|Terimakasih, Selamat Praktek|in";
                Storage::put($file, $image_base64);
            } else {
                echo "error|Maaf Gagal Absen, Silahkan Hubungi IT|in";
            }
        }
    }

    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Noveber", "Desember"];
        return view('pages.absensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if (!$bulan || !$tahun) {
            return response()->json(['message' => 'Bulan dan tahun wajib dipilih'], 400);
        }

        $histori = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_dpls', 'data_mahasiswas.dpl_id', '=', 'data_dpls.id')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->whereMonth('tgl_presensi', $bulan)
            ->whereYear('tgl_presensi', $tahun)
            ->orderBy('tgl_presensi')
            ->select(
                'presensis.*',
                'data_mahasiswas.nama',
                'data_sekolahs.nama_sekolah',
                'data_dpls.nama as nama_dpl'
            )
            ->get();

        return view('pages.absensi.gethistori', [
            'histori' => $histori,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }


    // absen histori sekolah dan pamong
    public function historiSekolah()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Noveber", "Desember"];
        return view('pages.absensi.histori-sekolah', compact('namabulan'));
    }

    public function gethistoriSekolah(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if (!$bulan || !$tahun) {
            return response()->json(['message' => 'Bulan dan tahun wajib dipilih'], 400);
        }

        $sekolah_npsn = Auth::guard('admin')->user()->npsn;

        $histori = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_dpls', 'data_mahasiswas.dpl_id', '=', 'data_dpls.id')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->where('data_sekolahs.npsn', $sekolah_npsn)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->select(
                'presensis.*',
                'data_mahasiswas.nama',
                'data_sekolahs.nama_sekolah as nama_sekolah', // Ambil nama mahasiswa dari tabel data_mahasiswas
                'data_dpls.nama as nama_dpl'
            )
            ->get();

        return view('pages.absensi.gethistori-sekolah', [
            'histori' => $histori,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    public function historiDpl()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Noveber", "Desember"];
        return view('pages.absensi.histori-dpl', compact('namabulan'));
    }

    public function gethistoriDpl(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if (!$bulan || !$tahun) {
            return response()->json(['message' => 'Bulan dan tahun wajib dipilih'], 400);
        }

        // $nama_dpl = Auth::guard('admin')->user()->name;
        $dpl_nip = Auth::guard('admin')->user()->nip; //coba pakai nip agar tidak ada kesalahan jika menggunakan nama

        $histori = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_dpls', 'data_mahasiswas.dpl_id', '=', 'data_dpls.id')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->where('data_dpls.nip', $dpl_nip)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->select(
                'presensis.*',
                'data_mahasiswas.nama',
                'data_sekolahs.nama_sekolah as nama_sekolah',
                'data_dpls.nama as nama_dpl'
            )
            ->get();

        return view('pages.absensi.gethistori-dpl', [
            'histori' => $histori,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    // Menampilkan PDF di browser
    public function showPDF(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $histori = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_dpls', 'data_mahasiswas.dpl_id', '=', 'data_dpls.id')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->select(
                'presensis.*',
                'data_mahasiswas.nama',
                'data_dpls.nama as nama_dpl',
                'data_sekolahs.nama_sekolah'
            )
            ->get();

        $pdf = Pdf::loadView('pages.absensi.presensiPDF', compact('histori', 'bulan', 'tahun'))->setPaper('a4', 'landscape');
        return $pdf->stream("presensi_{$bulan}_{$tahun}.pdf");
    }

    // Untuk download
    public function downloadPDF(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $histori = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_dpls', 'data_mahasiswas.dpl_id', '=', 'data_dpls.id')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->select(
                'presensis.*',
                'data_mahasiswas.nama',
                'data_dpls.nama as nama_dpl',
                'data_sekolahs.nama_sekolah'
            )
            ->get();

        $pdf = Pdf::loadView('pages.absensi.presensiPDF', compact('histori', 'bulan', 'tahun'))->setPaper('a4', 'landscape');
        return $pdf->download("presensi_{$bulan}_{$tahun}.pdf");
    }

    public function showPDFSekolah(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $sekolah_npsn = Auth::guard('admin')->user()->npsn;

        $histori = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_dpls', 'data_mahasiswas.dpl_id', '=', 'data_dpls.id')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->where('data_sekolahs.npsn', $sekolah_npsn)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->select(
                'presensis.*',
                'data_mahasiswas.nama',
                'data_sekolahs.nama_sekolah',
                'data_dpls.nama as nama_dpl'
            )
            ->get();
        $pdf = Pdf::loadView('pages.absensi.presensiSekolahPDF', compact('histori', 'bulan', 'tahun'))->setPaper('a4', 'landscape');

        return $pdf->stream("presensi_{$bulan}_{$tahun}.pdf"); // tampilkan
    }

    public function downloadPDFSekolah(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $sekolah_npsn = Auth::guard('admin')->user()->npsn;

        $histori = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_dpls', 'data_mahasiswas.dpl_id', '=', 'data_dpls.id')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->where('data_sekolahs.npsn', $sekolah_npsn)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->select(
                'presensis.*',
                'data_mahasiswas.nama',
                'data_sekolahs.nama_sekolah as nama_sekolah',
                'data_dpls.nama as nama_dpl'
            )
            ->get();

        $pdf = Pdf::loadView('pages.absensi.presensiSekolahPDF', compact('histori', 'bulan', 'tahun'))->setPaper('a4', 'landscape');

        return $pdf->download("presensi_{$bulan}_{$tahun}.pdf");
    }

    public function showPDFDpl(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $dpl_nip = Auth::guard('admin')->user()->nip;

        $histori = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_dpls', 'data_mahasiswas.dpl_id', '=', 'data_dpls.id')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->where('data_dpls.nip', $dpl_nip)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->select(
                'presensis.*',
                'data_mahasiswas.nama',
                'data_sekolahs.nama_sekolah as nama_sekolah',
                'data_dpls.nama as nama_dpl'
            )
            ->get();

        $pdf = Pdf::loadView('pages.absensi.presensiDplPDF', compact('histori', 'bulan', 'tahun'))->setPaper('a4', 'landscape');

        return $pdf->stream("presensi_{$bulan}_{$tahun}.pdf"); // tampilkan
    }

    public function downloadPDFDpl(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $dpl_nip = Auth::guard('admin')->user()->nip;

        $histori = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_dpls', 'data_mahasiswas.dpl_id', '=', 'data_dpls.id')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->where('data_dpls.nip', $dpl_nip)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->select(
                'presensis.*',
                'data_mahasiswas.nama',
                'data_sekolahs.nama_sekolah as nama_sekolah',
                'data_dpls.nama as nama_dpl'
            )
            ->get();

        $pdf = Pdf::loadView('pages.absensi.presensiDplPDF', compact('histori', 'bulan', 'tahun'))->setPaper('a4', 'landscape');

        return $pdf->download("presensi_{$bulan}_{$tahun}.pdf");
    }
}