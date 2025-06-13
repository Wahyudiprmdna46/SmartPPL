<?php

namespace App\Exports;

use App\Models\DataPamong;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PamongExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return DataPamong::all();
        return DataPamong::with('dataSekolah')->get()->map(function ($pamong) {
            return [
                'nip' => $pamong->nip,
                'nama' => $pamong->nama,
                'jenis_kelamin' => $pamong->jenis_kelamin ?? '-',
                'golongan' => $pamong->golongan ?? '-',
                'jabatan' => $pamong->jabatan ?? '-',
                'sekolah' => optional($pamong->dataSekolah)->nama_sekolah ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIM atau NIK',
            'Nama',
            'Jenis Kelamin',
            'Golongan',
            'Jabatan',
            'Nama Sekolah',
        ];
    }
}
