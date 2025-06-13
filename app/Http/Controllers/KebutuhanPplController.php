<?php

namespace App\Http\Controllers;

use App\Models\DataSekolah;
use App\Models\KebutuhanPpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KebutuhanPplController extends Controller
{
    private function generateTahunAjaran()
    {
        $start = 2024;
        $current = now()->year;
        $tahunAjaran = [];

        for ($i = $start; $i <= $current; $i++) {
            $tahunAjaran[] = $i . '/' . ($i + 1);
        }

        return $tahunAjaran;
    }

    // public function getJurusanTersisa(Request $request)
    // {
    //     $tahun = $request->tahun;

    //     // Semua jurusan yang tersedia
    //     $semuaJurusan = KebutuhanPpl::JURUSAN_LIST;

    //     // Jurusan yang sudah dipakai tahun ini
    //     $jurusanDipakai = KebutuhanPpl::where('tahun_ajaran', $tahun)
    //         ->pluck('jurusan')
    //         ->toArray();

    //     // Hitung jurusan yang tersisa
    //     $tersisa = array_values(array_diff($semuaJurusan, $jurusanDipakai));

    //     return response()->json([
    //         'jurusanTersisa' => $tersisa,
    //     ]);
    // }

    public function getJurusanTersisa(Request $request)
    {
        $tahun = $request->tahun;

        // Ambil sekolah_id berdasarkan user yang login
        $user = auth()->guard('admin')->user();
        $sekolah = DataSekolah::where('npsn', $user->npsn)->first();

        if (!$sekolah) {
            return response()->json(['jurusanTersisa' => []]);
        }

        // Semua jurusan yang tersedia
        $semuaJurusan = KebutuhanPpl::JURUSAN_LIST;

        // Jurusan yang sudah dipakai oleh sekolah ini di tahun ini
        $jurusanDipakai = KebutuhanPpl::where('tahun_ajaran', $tahun)
            ->where('sekolah_id', $sekolah->id) // ✅ filter by sekolah
            ->pluck('jurusan')
            ->toArray();

        // Hitung jurusan yang tersisa
        $tersisa = array_values(array_diff($semuaJurusan, $jurusanDipakai));

        return response()->json([
            'jurusanTersisa' => $tersisa,
        ]);
    }

    public function kuotaPpl(Request $request)
    {
        $user = auth()->guard('admin')->user(); // Bisa role 'sekolah' atau 'admin'
        $canDelete = in_array($user->role, ['sekolah', 'admin']); // Untuk kontrol aksi hapus

        if ($user->role === 'sekolah') {
            $sekolah = DataSekolah::where('npsn', $user->npsn)->first();

            if (!$sekolah) {
                return view('pages.kebutuhanppl.index', [
                    'kuotappls' => [],
                    'jumlahJurusan' => 0,
                    'tahunAjaranList' => [],
                    'request' => $request,
                    'canDelete' => $canDelete
                ]);
            }

            $query = KebutuhanPpl::where('sekolah_id', $sekolah->id);
            if ($request->filled('tahun_ajaran')) {
                $query->where('tahun_ajaran', $request->tahun_ajaran);
            }

            $tahunAjaranList = KebutuhanPpl::where('sekolah_id', $sekolah->id)
                ->select('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

            $jumlahJurusan = $query->count();
            $kuotappls = $query->with('sekolah')->paginate()->appends($request->all());

            return view('pages.kebutuhanppl.index', compact(
                'kuotappls',
                'jumlahJurusan',
                'tahunAjaranList',
                'request',
                'canDelete'
            ));
        }

        if ($user->role === 'admin') {
            $query = KebutuhanPpl::query();

            if ($request->filled('tahun_ajaran')) {
                $query->where('tahun_ajaran', $request->tahun_ajaran);
            }

            $kuotaBySekolah = $query
                ->with('sekolah')
                ->get()
                ->groupBy(function ($item) {
                    return $item->sekolah_id . '-' . $item->tahun_ajaran;
                });

            $tahunAjaranList = KebutuhanPpl::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

            return view('pages.admin.kebutuhanppl.index', [
                'kuotaBySekolah' => $kuotaBySekolah,
                'tahunAjaranList' => $tahunAjaranList,
                'request' => $request,
            ]);
        }

        return abort(403, 'Tidak punya akses');
    }

    public function create()
    {
        $tahunAjaran = $this->generateTahunAjaran();
        $jurusan = KebutuhanPpl::JURUSAN_LIST; // ✅ Ambil dari satu sumber
        return view('pages.kebutuhanppl.create', compact('jurusan', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'jurusan' => 'required|array',
            'jurusan.*' => ['in:' . implode(',', KebutuhanPpl::JURUSAN_LIST)],
            'jumlah_mahasiswa' => 'required|array',
        ]);

        $tahun = $request->tahun_ajaran;
        $jurusanInput = $request->jurusan;

        // Ambil jurusan yang sudah pernah diinput untuk tahun ini
        $jurusanTerpakai = KebutuhanPpl::where('tahun_ajaran', $tahun)
            ->pluck('jurusan')
            ->toArray();

        $duplikat = array_intersect($jurusanTerpakai, $jurusanInput);

        if (count($duplikat) > 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jurusan' => 'Jurusan berikut sudah dipakai untuk tahun ' . $tahun . ': ' . implode(', ', $duplikat)]);
        }

        // Simpan data
        $sekolah = DataSekolah::where('npsn', auth()->guard('admin')->user()->npsn)->first();

        foreach ($jurusanInput as $index => $jurusan) {
            KebutuhanPpl::create([
                'sekolah_id' => $sekolah->id, // ✅ Tambah ini
                'tahun_ajaran' => $tahun,
                'jurusan' => $jurusan,
                'jumlah_mahasiswa' => $request->jumlah_mahasiswa[$index],
            ]);
        }

        return redirect()->route('kuotappl')->with('success', 'Data berhasil ditambahkan.');
    }

    public function detail(Request $request)
    {
        $sekolahId = $request->sekolah;
        $tahun = $request->tahun;
        $sekolah = DataSekolah::findOrFail($sekolahId);
        $kuotaList = KebutuhanPpl::where('sekolah_id', $sekolahId)
            ->where('tahun_ajaran', $tahun)
            ->get();

        return view('pages.admin.kebutuhanppl.detail', compact('sekolah', 'tahun', 'kuotaList'));
    }

    public function delete($id)
    {
        $kuota = KebutuhanPpl::findOrFail($id);
        $kuota->delete();

        return redirect()->route('kuotappl')->with('success', 'Data berhasil dihapus!');
    }

    public function deletePerSekolahTahun($sekolah, $tahun)
    {
        $user = auth()->guard('admin')->user();

        if ($user->role !== 'admin') {
            abort(403);
        }

        $deleted = KebutuhanPpl::where('sekolah_id', $sekolah)
            ->where('tahun_ajaran', $tahun)
            ->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Data kebutuhan PPL berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data. Mungkin data tidak ditemukan.');
        }
    }
}
