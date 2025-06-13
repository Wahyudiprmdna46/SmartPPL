<?php

namespace App\Exports;

use App\Models\DataMahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MahasiswaExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return DataMahasiswa::all();
        return DataMahasiswa::with(['dataDpl', 'dataSekolah', 'dataPamong', 'laporanPpl', 'penilaian'])->get()->map(function ($mhs) {
            return [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'jenis_kelamin' => $mhs->jenis_kelamin ?? '-',
                'jurusan' => $mhs->jurusan,
                'dpl' => optional($mhs->dataDpl)->nama ?? '-',
                'sekolah' => optional($mhs->dataSekolah)->nama_sekolah ?? '-',
                'pamong' => optional($mhs->dataPamong)->nama ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Jenis Kelamin',
            'Jurusan',
            'Nama DPL',
            'Nama Sekolah',
            'Nama Pamong',
        ];
    }
}
