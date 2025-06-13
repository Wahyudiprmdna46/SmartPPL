<?php

namespace App\Http\Controllers;

use App\Models\DataDpl;
use App\Models\DataMahasiswa;
use App\Models\DataPamong;
use App\Models\DataSekolah;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class PenilaianController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('role', ['admin', 'dpl', 'sekolah', 'pamong'])) {
                return redirect('admin/dashboard')->with('error', 'Anda tidak memiliki izin.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $user = Auth::guard('admin')->user();

        $penilaians = collect();
        $mahasiswas = [];

        // Cek role login
        if ($user->role === 'admin') {
            $penilaians = Penilaian::with('dataMahasiswa')->paginate(5);
            $mahasiswas = DataMahasiswa::all();
        } elseif ($user->role === 'pamong') {
            $pamong = DataPamong::where(function ($query) use ($user) {
                $query->where('nip', $user->nip)
                      ->orWhere('nip', $user->nik);
            })->first();
            
            if ($pamong) {
                $penilaians = Penilaian::with('dataMahasiswa')
                    ->whereHas('dataMahasiswa', fn($q) => $q->where('pamong_id', $pamong->id))
                    ->paginate(10);

                $mahasiswas = DataMahasiswa::where('pamong_id', $pamong->id)->get();
            }
        } elseif ($user->role === 'dpl') {
            $dpl = DataDpl::where('nip', $user->nip)->first();
            if ($dpl) {
                $penilaians = Penilaian::with('dataMahasiswa')
                    ->whereHas('dataMahasiswa', fn($q) => $q->where('dpl_id', $dpl->id))
                    ->paginate(10);

                $mahasiswas = DataMahasiswa::where('dpl_id', $dpl->id)->get();
            }
        } elseif ($user->role === 'sekolah') {
            $sekolah = DataSekolah::where('npsn', $user->npsn)->first(); // atau 'npsn', tergantung struktur
            if ($sekolah) {
                $penilaians = Penilaian::with('dataMahasiswa')
                    ->whereHas('dataMahasiswa', fn($q) => $q->where('sekolah_id', $sekolah->id))
                    ->paginate(10);

                $mahasiswas = DataMahasiswa::where('sekolah_id', $sekolah->id)->get();
            }
        }

        // Cek hak akses
        $canUpload = in_array($user->role, ['pamong']);
        $canEdit = in_array($user->role, ['pamong']);
        $canDelete = in_array($user->role, ['admin', 'pamong']);
        $canExport = in_array($user->role, ['admin', 'dpl', 'sekolah', 'pamong']);

        return view('pages.kelolamahasiswa.kelolapenilaian.index', compact('penilaians', 'mahasiswas', 'canUpload', 'canEdit', 'canDelete', 'canExport'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:data_mahasiswas,id',
            'persiapan_mengajar' => 'nullable|numeric',
            'praktek_mengajar' => 'nullable|numeric',
            'laporan_ppl' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        // Hitung nilai akhir
        $persiapanMengajar = $request->input('persiapan_mengajar') ?? 0;
        $praktekMengajar = $request->input('praktek_mengajar') ?? 0;
        $laporanPpl = $request->input('laporan_ppl') ?? 0;

        $nilaiAkhir = round((($persiapanMengajar*2) + ($praktekMengajar*5) + ($laporanPpl*3)),2 );

        Penilaian::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'persiapan_mengajar' => $persiapanMengajar,
            'praktek_mengajar' => $praktekMengajar,
            'laporan_ppl' => $laporanPpl,
            'nilai_akhir' => $nilaiAkhir,
            'catatan' => $request->catatan,
        ]);
        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'persiapan_mengajar' => 'nullable|numeric',
            'praktek_mengajar' => 'nullable|numeric',
            'laporan_ppl' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        $penilaian = Penilaian::findOrFail($id);

        $persiapanMengajar = $request->input('persiapan_mengajar') ?? 0;
        $praktekMengajar = $request->input('praktek_mengajar') ?? 0;
        $laporanPpl = $request->input('laporan_ppl') ?? 0;

        $nilaiAkhir = round((($persiapanMengajar*2) + ($praktekMengajar*5) + ($laporanPpl*3)), 2);

        $penilaian->update([
            'persiapan_mengajar' => $persiapanMengajar,
            'praktek_mengajar' => $praktekMengajar,
            'laporan_ppl' => $laporanPpl,
            'nilai_akhir' => $nilaiAkhir,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diperbarui');
    }


    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();
        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil dihapus');
    }
}