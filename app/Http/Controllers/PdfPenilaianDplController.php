<?php

namespace App\Http\Controllers;

use App\Models\PenilaianDpl;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfPenilaianDplController extends Controller
{
    public function generatePDF($id)
    {
        $penilaian = PenilaianDpl::with('mahasiswa')->findOrFail($id);

        $data = [
            'data' => $penilaian,
            'mahasiswa' => $penilaian->mahasiswa,
            'tittle' => 'Laporan Penilaian DPL',
            'date' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('pages.kelolamahasiswa.penilaiandpl.penilaianPDF', $data);
        return $pdf->download('penilaian-dpl-' . $penilaian->mahasiswa->nim . '.pdf');
    }

    public function showPDF($id)
    {
        $penilaian = PenilaianDpl::with('mahasiswa')->findOrFail($id);

        $data = [
            'data' => $penilaian,
            'mahasiswa' => $penilaian->mahasiswa,
            'tittle' => 'Laporan Penilaian DPL',
            'date' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('pages.kelolamahasiswa.penilaiandpl.penilaianPDF', $data);
        return $pdf->stream('penilaian-dpl-' . $penilaian->mahasiswa->nim . '.pdf');
    }
}
