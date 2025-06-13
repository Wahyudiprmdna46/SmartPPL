<?php

namespace App\Exports;

use App\Models\DataDpl;
use App\Models\DataMahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class NilaiAkhirExport implements FromCollection, WithHeadings
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        $dpl = DataDpl::where('nip', $this->user->nip)->first();

        $dataMahasiswaQuery = DataMahasiswa::with(['dataDpl', 'dataSekolah', 'dataPamong', 'penilaian', 'penilaianDpl'])
            ->where(function ($query) {
                $query->whereHas('penilaian')
                    ->orWhereHas('penilaianDpl');
            });

        if ($this->user->role === 'dpl' && $dpl) {
            $dataMahasiswaQuery->where('dpl_id', $dpl->id);
        }

        $data = $dataMahasiswaQuery->get();

        return $data->map(function ($mhs) {
            $nilaiPamong = $mhs->penilaian->nilai_akhir ?? 0;
            $nilaiDpl = $mhs->penilaianDpl->nilai_akhir ?? 0;
            $nilaiAkhir = round(($nilaiPamong + $nilaiDpl) / ($nilaiPamong && $nilaiDpl ? 2 : 1), 2);

            return [
                'NIM' => $mhs->nim,
                'Nama Mahasiswa' => $mhs->nama,
                'DPL' => $mhs->dataDpl->nama ?? '-',
                'Sekolah' => $mhs->dataSekolah->nama_sekolah ?? '-',
                'Pamong' => $mhs->dataPamong->nama ?? '-',
                'Nilai Pamong' => $nilaiPamong,
                'Nilai DPL' => $nilaiDpl,
                'Nilai Akhir' => $nilaiAkhir,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Mahasiswa',
            'DPL',
            'Sekolah',
            'Pamong',
            'Nilai Pamong',
            'Nilai DPL',
            'Nilai Akhir',
        ];
    }
}
