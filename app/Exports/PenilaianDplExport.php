<?php

namespace App\Exports;

use App\Models\PenilaianDpl;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenilaianDplExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PenilaianDpl::with(['mahasiswa', 'dpl'])->get()->map(function ($item) {
            return [
                'Nama Mahasiswa' => $item->mahasiswa->nama ?? '-',
                'NIM' => $item->mahasiswa->nim ?? '-',
                'DPL' => optional($item->dpl)->nama ?? '-',
                'Persiapan Mengajar' => $item->persiapan_mengajar,
                'Praktek Mengajar' => $item->praktek_mengajar,
                'Laporan PPL' => $item->laporan_ppl,
                'Nilai Akhir' => $item->nilai_akhir,
                'Catatan' => $item->catatan,
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'DPL',
            'Persiapan Mengajar',
            'Praktek Mengajar',
            'Laporan PPL',
            'Nilai Akhir',
            'Catatan',
        ];
    }
}
