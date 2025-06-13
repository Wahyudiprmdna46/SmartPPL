<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfPenilaianController extends Controller
{
    public function generatePDF($id)
    {
        $penilaian = Penilaian::with('dataMahasiswa.dataPamong.dataSekolah')->findOrFail($id);

        $data = [
            'data' => $penilaian,
            'dataSekolah' => $penilaian->dataMahasiswa->dataPamong->dataSekolah ?? null,
            'tittle' => 'laporan penilaian mahasiswa',
            'date' => date('m/d/Y'),
            'penilaian' => $penilaian,
        ];

        $pdf = PDF::loadView('pages.kelolamahasiswa.kelolapenilaian.penilaianPDF', $data);
        return $pdf->download('penilaian-' . $penilaian->dataMahasiswa->nim . '.pdf');
    }

    public function showPDF($id)
    {
        $penilaian = Penilaian::with('dataMahasiswa.dataPamong.dataSekolah')->findOrFail($id);

        $data = [
            'data' => $penilaian,
            'dataSekolah' => $penilaian->dataMahasiswa->dataPamong->dataSekolah ?? null,
            'tittle' => 'laporan penilaian mahasiswa',
            'date' => date('m/d/Y'),
            'penilaian' => $penilaian,
        ];

        $pdf = PDF::loadView('pages.kelolamahasiswa.kelolapenilaian.penilaianPDF', $data);
        return $pdf->stream('penilaian-' . $penilaian->dataMahasiswa->nim . '.pdf');
    }
}