<?php

namespace App\Exports;

use App\Models\DataDpl;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DplExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return DataDpl::all();
        return DataDpl::all()->map(function ($dpl) {
            return [
                'nip' => $dpl->nip,
                'nama' => $dpl->nama,
                'golongan' => $dpl->golongan,
                'jabatan' => $dpl->jabatan,
                'jenis_kelamin' => $dpl->jenis_kelamin,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama',
            'Golongan',
            'Jabatan',
            'Jenis Kelamin',
        ];
    }
}
