<?php

namespace App\Http\Controllers;

use App\Models\DataMahasiswa;
use App\Models\DataSekolah;
use App\Models\PengajuanPpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanPplController extends Controller
{
    public function create()
    {
        $sekolahs = DataSekolah::all();
        $user = Auth::guard('admin')->user();
        $dataMahasiswa = DataMahasiswa::where('nim', $user->nim)->first();

        $pengajuan = PengajuanPpl::where('data_mahasiswa_id', $dataMahasiswa->id)
            ->with('sekolah')
            ->latest()
            ->first(); // hanya ambil 1 data

        // Cek manual apakah mahasiswa sudah punya sekolah_id
        $sudahDiterima = !is_null($dataMahasiswa->sekolah_id);

        return view('pages.mahasiswa.pendaftaranppl', compact('sekolahs', 'dataMahasiswa', 'pengajuan', 'sudahDiterima'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:data_sekolahs,id',
        ]);

        $user = Auth::guard('admin')->user();
        $dataMahasiswa = DataMahasiswa::where('nim', $user->nim)->first();

        // Cek apakah sudah ada pengajuan sebelumnya
        $existingPengajuan = PengajuanPpl::where('data_mahasiswa_id', $dataMahasiswa->id)->first();

        if ($existingPengajuan) {
            // Kalau ada, hapus dulu
            $existingPengajuan->delete();
        }

        // Buat pengajuan baru
        PengajuanPpl::create([
            'admin_id' => $user->id,
            'data_mahasiswa_id' => $dataMahasiswa->id,
            'sekolah_id' => $request->sekolah_id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan PPL berhasil dikirim!');
    }

    public function index()
    {
        $pengajuans = PengajuanPpl::with('mahasiswa', 'dataMahasiswa', 'sekolah')
            ->select('pengajuan_ppls.*')
            ->join(DB::raw('(SELECT MAX(id) as id FROM pengajuan_ppls GROUP BY data_mahasiswa_id) as latest'), function ($join) {
                $join->on('pengajuan_ppls.id', '=', 'latest.id');
            })
            ->paginate(10);

        return view('pages.admin.pengajuanppl.index', compact('pengajuans'));
    }

    public function updateStatus($id, $status)
    {
        $pengajuan = PengajuanPpl::findOrFail($id);
        $pengajuan->status = $status;
        $pengajuan->save();

        if ($status == 'approved') {
            // Cari sekolah yang dipilih
            $sekolah = DataSekolah::find($pengajuan->sekolah_id);

            if ($sekolah) {
                // Update data mahasiswa
                $dataMahasiswa = DataMahasiswa::find($pengajuan->data_mahasiswa_id);
                if ($dataMahasiswa) {
                    $dataMahasiswa->update([
                        'dpl_id' => $sekolah->dpl_id, // ambil dari sekolah
                        'sekolah_id' => $sekolah->id,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Status berhasil diupdate.');
    }
}