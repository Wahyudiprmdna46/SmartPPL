<?php

namespace App\Http\Controllers;

use App\Exports\PenilaianDplExport;
use App\Models\DataDpl;
use App\Models\DataMahasiswa;
use App\Models\PenilaianDpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianDplController extends Controller
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
        $dpl = DataDpl::where('nip', $user->nip)->first();

        $penilaians = collect();
        $mahasiswas = [];

        // Cek role login
        if ($user->role === 'admin') {
            $penilaians = PenilaianDpl::with(['mahasiswa', 'dpl'])->paginate(10);
            $mahasiswas = DataMahasiswa::all();
        } elseif ($user->role === 'dpl') {
            $penilaians = PenilaianDpl::with(['mahasiswa', 'dpl'])
                ->whereHas('mahasiswa', function ($query) use ($dpl) {
                    $query->where('dpl_id', $dpl->id);
                })
                ->paginate(10);
            $mahasiswas = DataMahasiswa::where('dpl_id', $dpl->id)->get();
        }

        $canUpload = in_array($user->role, ['dpl']);
        $canEdit = in_array($user->role, ['dpl', 'admin']);
        $canDelete = in_array($user->role, ['admin', 'dpl']);
        $canExport = in_array($user->role, ['admin', 'dpl']);

        return view(
            'pages.kelolamahasiswa.penilaiandpl.index',
            compact(
                'penilaians',
                'mahasiswas',
                'canEdit',
                'canDelete',
                'canUpload',
                'canExport'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:data_mahasiswas,id',
            'persiapan_mengajar' => 'required|numeric',
            'praktek_mengajar' => 'required|numeric',
            'laporan_ppl' => 'required|numeric',
            'catatan' => 'nullable|string',
        ]);

        $mahasiswa = DataMahasiswa::findOrFail($request->mahasiswa_id);

        // Hitung nilai akhir
        $persiapanMengajar = $request->input('persiapan_mengajar') ?? 0;
        $praktekMengajar = $request->input('praktek_mengajar') ?? 0;
        $laporanPpl = $request->input('laporan_ppl') ?? 0;

        $nilaiAkhir = round((($persiapanMengajar * 2) + ($praktekMengajar * 5) + ($laporanPpl * 3)), 2);

        PenilaianDpl::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dpl_id' => $mahasiswa->dpl_id,
            'persiapan_mengajar' => $request->persiapan_mengajar,
            'praktek_mengajar' => $request->praktek_mengajar,
            'laporan_ppl' => $request->laporan_ppl,
            'nilai_akhir' => $nilaiAkhir,
            'catatan' => $request->catatan,
        ]);
        return redirect()->back()->with('success', 'Penilaian berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'persiapan_mengajar' => 'nullable|numeric',
            'praktek_mengajar' => 'nullable|numeric',
            'laporan_ppl' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        $penilaian = PenilaianDpl::findOrFail($id);

        $persiapanMengajar = $request->input('persiapan_mengajar') ?? 0;
        $praktekMengajar = $request->input('praktek_mengajar') ?? 0;
        $laporanPpl = $request->input('laporan_ppl') ?? 0;

        $nilaiAkhir = round((($persiapanMengajar * 2) + ($praktekMengajar * 5) + ($laporanPpl * 3)), 2);

        $penilaian->update([
            'persiapan_mengajar' => $persiapanMengajar,
            'praktek_mengajar' => $praktekMengajar,
            'laporan_ppl' => $laporanPpl,
            'nilai_akhir' => $nilaiAkhir,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('penilaiandpl.index')->with('success', 'Penilaian berhasil diperbarui');
    }

    public function exportExcelPenilaianDpl()
    {
        return Excel::download(new PenilaianDplExport, 'data-nilai-mahasiswa-dpl.xlsx');
    }

    public function destroy(PenilaianDpl $penilaiandpl)
    {
        $penilaiandpl->delete();
        return redirect()->route('penilaiandpl.index')->with('success', 'Penilaian berhasil dihapus');
    }
}
