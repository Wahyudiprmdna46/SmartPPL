<?php

namespace App\Http\Controllers;

use App\Exports\NilaiAkhirExport;
use App\Models\DataDpl;
use App\Models\PenilaianPamong;
use App\Models\PenilaianDpl;
use App\Models\DataMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class NilaiAkhirController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        $dpl = DataDpl::where('nip', $user->nip)->first();

        // Ambil mahasiswa yang sudah memiliki nilai pamong dan dpl
        $dataMahasiswaQuery = DataMahasiswa::with(['dataDpl', 'dataSekolah', 'dataPamong', 'penilaian', 'penilaianDpl'])
            ->where(function ($query) {
                $query->whereHas('penilaian')
                    ->orWhereHas('penilaianDpl');
            });

        if ($user->role === 'dpl' && $dpl) {
            $dataMahasiswaQuery->where('dpl_id', $dpl->id);
        }

        $data = $dataMahasiswaQuery->get();

        // Hitung nilai akhir dan kumpulkan data
        $nilaiAkhirList = $data->map(function ($mhs) {
            $nilaiPamong = $mhs->penilaian->nilai_akhir ?? 0;
            $nilaiDpl = $mhs->penilaianDpl->nilai_akhir ?? 0;
            $nilaiAkhir = round(($nilaiPamong + $nilaiDpl) / ($nilaiPamong && $nilaiDpl ? 2 : 1), 2); // Jika salah satu kosong, jangan dibagi 2

            return (object)[
                'id' => $mhs->id,
                'nim' => $mhs->nim,
                'nama_mahasiswa' => $mhs->nama,
                'nama_dpl' => $mhs->dataDpl->nama ?? '-',
                'nama_sekolah' => $mhs->dataSekolah->nama_sekolah ?? '-',
                'nama_pamong' => $mhs->dataPamong->nama ?? '-',
                'nilai_pamong' => $nilaiPamong,
                'nilai_dpl' => $nilaiDpl,
                'nilai_akhir' => $nilaiAkhir,
            ];
        });

        // Paginate manual (karena hasil dari map)
        $perPage = 10;
        $page = request()->get('page', 1);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $nilaiAkhirList->forPage($page, $perPage),
            $nilaiAkhirList->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pages.kelolamahasiswa.nilaiakhir.index', ['datamahasiswas' => $paginated]);
    }

    public function export()
    {
        $user = Auth::guard('admin')->user();
        return Excel::download(new NilaiAkhirExport($user), 'nilai_akhir_mahasiswa.xlsx');
    }

    public function destroy($id)
    {
        $mahasiswa = DataMahasiswa::findOrFail($id);

        // Hapus penilaian dari pamong jika ada
        if ($mahasiswa->penilaian) {
            $mahasiswa->penilaian->delete();
        }

        // Hapus penilaian dari DPL jika ada
        if ($mahasiswa->penilaianDpl) {
            $mahasiswa->penilaianDpl->delete();
        }

        return redirect()->back()->with('success', 'Data nilai akhir mahasiswa berhasil dihapus.');
    }
}
